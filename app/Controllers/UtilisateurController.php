<?php
require_once __DIR__ . '/../Models/Utilisateur.php';

class UtilisateurController extends Controller
{
    private const ALLOWED_ROLES = ['Admin', 'Journaliste', 'Community Manager'];

    public function index(): void
    {
        $this->requireRole(['Admin']);
        $model = new Utilisateur();
        $utilisateurs = $model->findAll();
        $this->view('utilisateurs/index', ['title' => 'Utilisateurs', 'utilisateurs' => $utilisateurs]);
    }

    public function show(int $id): void
    {
        $this->requireRole(['Admin']);
        $model = new Utilisateur();
        $utilisateur = $model->findById($id);
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

        if ($model->createUser($data)) {
            $this->flash('success', 'Utilisateur cree avec succes.');
        } else {
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

        if ($model->updateUser($id, $data)) {
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
