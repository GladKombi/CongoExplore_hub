<?php
require_once __DIR__ . '/../Models/MediaGallery.php';
require_once __DIR__ . '/../Models/Contenu.php';

class MediaController extends Controller
{
    private const ALLOWED_TYPES = ['Photo', 'Video', 'Interview', 'Reportage'];
    private const ALLOWED_IMAGE_TYPES = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
    private const MAX_MEDIA_PER_CONTENT = 3;
    private const MAX_UPLOAD_SIZE = 5242880;

    public function index(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $mediaModel = new MediaGallery();
        $contentModel = new Contenu();

        $medias = $mediaModel->findAllWithContent();
        $contenus = $contentModel->findAllWithRelations();

        $this->view('medias/index', ['title' => 'Medias', 'medias' => $medias, 'contenus' => $contenus]);
    }

    public function create(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $data = $this->validatedMediaData();
        if ($data === null) {
            $this->redirect('media');
        }

        $model = new MediaGallery();
        if ($model->countByContenuId($data['contenu_id']) >= self::MAX_MEDIA_PER_CONTENT) {
            $this->flash('error', 'Ce contenu a deja 3 medias. Supprimez un media avant d’en ajouter un autre.');
            $this->redirect('media');
        }

        if ($model->createMedia($data)) {
            $this->flash('success', 'Media ajoute avec succes.');
        } else {
            $this->flash('error', 'Impossible d’ajouter ce media.');
        }

        $this->redirect('media');
    }

    public function delete(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->flash('error', 'Media introuvable.');
            $this->redirect('media');
        }

        $model = new MediaGallery();
        if ($model->softDelete($id)) {
            $this->flash('success', 'Media supprime avec succes.');
        } else {
            $this->flash('error', 'Impossible de supprimer ce media.');
        }

        $this->redirect('media');
    }

    private function validatedMediaData(): ?array
    {
        $contenuId = filter_input(INPUT_POST, 'contenu_id', FILTER_VALIDATE_INT);
        $typeMedia = trim((string)($_POST['type_media'] ?? ''));

        if (!$contenuId) {
            $this->flash('error', 'Publication obligatoire.');
            return null;
        }

        if (!in_array($typeMedia, self::ALLOWED_TYPES, true)) {
            $this->flash('error', 'Type de media invalide.');
            return null;
        }

        $uploadedPath = $this->storeUploadedImage();
        if ($uploadedPath === null) {
            return null;
        }

        return [
            'contenu_id' => $contenuId,
            'type_media' => $typeMedia,
            'url_fichier' => $uploadedPath,
        ];
    }

    private function storeUploadedImage(): ?string
    {
        $file = $_FILES['fichier_media'] ?? null;

        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $this->flash('error', 'Image obligatoire ou upload invalide.');
            return null;
        }

        if (($file['size'] ?? 0) > self::MAX_UPLOAD_SIZE) {
            $this->flash('error', 'L’image ne doit pas depasser 5 Mo.');
            return null;
        }

        $mimeType = mime_content_type((string)$file['tmp_name']);
        if (!isset(self::ALLOWED_IMAGE_TYPES[$mimeType])) {
            $this->flash('error', 'Format image invalide. Utilisez JPG, PNG, WEBP ou GIF.');
            return null;
        }

        $uploadDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'contenus';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
            $this->flash('error', 'Impossible de creer le dossier upload.');
            return null;
        }

        $extension = self::ALLOWED_IMAGE_TYPES[$mimeType];
        $fileName = 'media_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
        $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

        if (!move_uploaded_file((string)$file['tmp_name'], $targetPath)) {
            $this->flash('error', 'Impossible d’enregistrer l’image.');
            return null;
        }

        return 'uploads/contenus/' . $fileName;
    }

    private function requirePost(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('media');
        }
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION['toast'] = ['type' => $type, 'message' => $message];
    }
}
