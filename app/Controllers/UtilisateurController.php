<?php
require_once __DIR__ . '/../Models/Utilisateur.php';
require_once __DIR__ . '/../Models/ProfilUtilisateur.php';

class UtilisateurController extends Controller
{
    private const ALLOWED_ROLES = ['Admin', 'Journaliste', 'Community Manager'];

    public function index(): void
    {
        $this->requireRole(['Admin']);
        $model = new Utilisateur();
        $utilisateurs = $model->findAllWithProfiles();
        $this->view('utilisateurs/index', ['title' => 'Utilisateurs', 'utilisateurs' => $utilisateurs]);
    }

    public function show(int $id): void
    {
        $this->requireRole(['Admin']);
        $model = new Utilisateur();
        $utilisateur = $model->findByIdWithProfile($id);
        $this->view('utilisateurs/show', ['title' => 'Utilisateur', 'utilisateur' => $utilisateur]);
    }

    public function create(): void
    {
        $this->requireRole(['Admin']);
        $this->requirePost();

        $data = $this->validatedUserData(true);
        if ($data === null) {
            $this->redirect('utilisateur');
        }

        $model = new Utilisateur();
        if ($model->emailExists($data['email'])) {
            $this->flash('error', 'Cette adresse email est deja utilisee.');
            $this->redirect('utilisateur');
        }

        $data['mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);

        $photo = $this->uploadProfilePhoto();
        if ($photo === false) {
            $this->redirect('utilisateur');
        }

        $userId = $model->createUser($data);
        if ($userId !== false) {
            if (is_string($photo)) {
                $profileModel = new ProfilUtilisateur();
                $fullName = trim($data['prenom'] . ' ' . $data['nom']);
                if (!$profileModel->savePhoto($userId, $fullName, $photo)) {
                    $this->removeUploadedPhoto($photo);
                    $this->flash('error', 'Le compte a ete cree, mais la photo n’a pas pu etre enregistree.');
                    $this->redirect('utilisateur');
                }
            }
            $this->flash('success', 'Utilisateur cree avec succes.');
        } else {
            if (is_string($photo)) {
                $this->removeUploadedPhoto($photo);
            }
            $this->flash('error', 'Impossible de creer cet utilisateur.');
        }

        $this->redirect('utilisateur');
    }

    public function update(): void
    {
        $this->requireRole(['Admin']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->flash('error', 'Utilisateur introuvable.');
            $this->redirect('utilisateur');
        }

        $data = $this->validatedUserData(false);
        if ($data === null) {
            $this->redirect('utilisateur');
        }

        $model = new Utilisateur();
        if (!$model->findById($id)) {
            $this->flash('error', 'Utilisateur introuvable.');
            $this->redirect('utilisateur');
        }

        if ($model->emailExists($data['email'], $id)) {
            $this->flash('error', 'Cette adresse email est deja utilisee.');
            $this->redirect('utilisateur');
        }

        if (!empty($data['mot_de_passe'])) {
            $data['mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
        }

        $photo = $this->uploadProfilePhoto();
        if ($photo === false) {
            $this->redirect('utilisateur');
        }

        if ($model->updateUser($id, $data)) {
            if (is_string($photo)) {
                $profileModel = new ProfilUtilisateur();
                $oldProfile = $profileModel->findByUtilisateurId($id);
                $fullName = trim($data['prenom'] . ' ' . $data['nom']);

                if (!$profileModel->savePhoto($id, $fullName, $photo)) {
                    $this->removeUploadedPhoto($photo);
                    $this->flash('error', 'Le compte a ete modifie, mais la photo n’a pas pu etre enregistree.');
                    $this->redirect('utilisateur');
                }

                $this->removeUploadedPhoto($oldProfile['photo_profil'] ?? null);
                if ((int)($_SESSION['user']['id'] ?? 0) === $id) {
                    $_SESSION['user']['photo_profil'] = $photo;
                }
            }
            $this->flash('success', 'Utilisateur mis a jour avec succes.');
        } else {
            $this->flash('error', 'Impossible de mettre a jour cet utilisateur.');
        }

        $this->redirect('utilisateur');
    }

    public function delete(): void
    {
        $this->requireRole(['Admin']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->flash('error', 'Utilisateur introuvable.');
            $this->redirect('utilisateur');
        }

        $currentUser = $_SESSION['user'] ?? [];
        if ((int)($currentUser['id'] ?? 0) === (int)$id) {
            $this->flash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
            $this->redirect('utilisateur');
        }

        $model = new Utilisateur();
        if ($model->softDelete($id)) {
            $this->flash('success', 'Utilisateur supprime avec succes.');
        } else {
            $this->flash('error', 'Impossible de supprimer cet utilisateur.');
        }

        $this->redirect('utilisateur');
    }

    private function requirePost(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('utilisateur');
        }
    }

    private function validatedUserData(bool $passwordRequired): ?array
    {
        $nom = trim((string)($_POST['nom'] ?? ''));
        $prenom = trim((string)($_POST['prenom'] ?? ''));
        $role = trim((string)($_POST['role'] ?? ''));
        $password = (string)($_POST['mot_de_passe'] ?? '');

        if ($nom === '' || $prenom === '' || $role === '') {
            $this->flash('error', 'Tous les champs obligatoires doivent etre remplis.');
            return null;
        }

        $email = $this->generateEmail($nom, $prenom);
        if ($email === null) {
            $this->flash('error', 'Impossible de generer une adresse email avec ce nom et ce prenom.');
            return null;
        }

        if (!in_array($role, self::ALLOWED_ROLES, true)) {
            $this->flash('error', 'Role invalide.');
            return null;
        }

        if ($passwordRequired && strlen($password) < 4) {
            $this->flash('error', 'Le mot de passe doit contenir au moins 4 caracteres.');
            return null;
        }

        if (!$passwordRequired && $password !== '' && strlen($password) < 4) {
            $this->flash('error', 'Le nouveau mot de passe doit contenir au moins 4 caracteres.');
            return null;
        }

        return [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'role' => $role,
            'mot_de_passe' => $password,
        ];
    }

    private function generateEmail(string $nom, string $prenom): ?string
    {
        $nomSlug = $this->slugForEmail($nom);
        $prenomSlug = $this->slugForEmail($prenom);

        if ($nomSlug === '' || $prenomSlug === '') {
            return null;
        }

        return $nomSlug . '-' . $prenomSlug . '@congoexplorerhub.com';
    }

    private function uploadProfilePhoto(): string|false|null
    {
        $file = $_FILES['photo_profil'] ?? null;
        if (!$file || (int)($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ((int)$file['error'] !== UPLOAD_ERR_OK || (int)$file['size'] > 1024 * 1024) {
            $this->flash('error', 'La photo est invalide ou depasse la taille maximale de 1 Mo.');
            return false;
        }

        $mime = (new finfo(FILEINFO_MIME_TYPE))->file((string)$file['tmp_name']);
        $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        if (!isset($extensions[$mime])) {
            $this->flash('error', 'Format non accepte. Utilisez une image JPEG, PNG ou WebP.');
            return false;
        }

        $directory = dirname(__DIR__, 2) . '/uploads/profils';
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            $this->flash('error', 'Impossible de preparer le dossier des photos.');
            return false;
        }

        $fileName = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
        if (!move_uploaded_file((string)$file['tmp_name'], $directory . '/' . $fileName)) {
            $this->flash('error', 'Le televersement de la photo a echoue.');
            return false;
        }

        return 'uploads/profils/' . $fileName;
    }

    private function removeUploadedPhoto(?string $path): void
    {
        if (!$path || !str_starts_with($path, 'uploads/profils/')) {
            return;
        }

        $absolutePath = dirname(__DIR__, 2) . '/' . $path;
        if (is_file($absolutePath)) {
            unlink($absolutePath);
        }
    }

    private function slugForEmail(string $value): string
    {
        $value = trim($value);

        if (function_exists('iconv')) {
            $converted = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
            if ($converted !== false) {
                $value = $converted;
            }
        }

        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';
        return trim($value, '-');
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION['toast'] = [
            'type' => $type,
            'message' => $message,
        ];
    }
}
