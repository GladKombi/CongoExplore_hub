<?php
require_once __DIR__ . '/../Models/Evenement.php';
require_once __DIR__ . '/../Models/Client.php';
require_once __DIR__ . '/../Models/MediaEvenement.php';

class EvenementController extends Controller
{
    private const ALLOWED_TYPES = ['Interne', 'Client'];
    private const ALLOWED_MEDIA_TYPES = ['Photo', 'Video', 'Interview', 'Reportage'];
    private const ALLOWED_IMAGE_TYPES = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
    private const MAX_MEDIA_PER_EVENT = 3;
    private const MAX_UPLOAD_SIZE = 5242880;

    public function index(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $eventModel = new Evenement();
        $clientModel = new Client();
        $mediaModel = new MediaEvenement();

        $evenements = $eventModel->findAllWithClient();
        $clients = $clientModel->findAll();
        $medias = $mediaModel->findAllWithEvent();

        $this->view('evenements/index', [
            'title' => 'Evenements',
            'evenements' => $evenements,
            'clients' => $clients,
            'medias' => $medias,
        ]);
    }

    public function show(int $id): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $eventModel = new Evenement();
        $mediaModel = new MediaEvenement();

        $evenement = $eventModel->findByIdWithClient($id);
        $medias = $mediaModel->findByEvenementId($id);

        $this->view('evenements/show', ['title' => 'Evenement', 'evenement' => $evenement, 'medias' => $medias]);
    }

    public function create(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $data = $this->validatedEventData();
        if ($data === null) {
            $this->redirect('evenement');
        }

        $model = new Evenement();
        $created = $model->createEvent($data);
        $this->flash($created ? 'success' : 'error', $created ? 'Evenement cree avec succes.' : 'Impossible de creer cet evenement.');
        $this->redirect('evenement');
    }

    public function update(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $data = $this->validatedEventData();

        if (!$id || $data === null) {
            $this->flash('error', 'Evenement introuvable.');
            $this->redirect('evenement');
        }

        $model = new Evenement();
        $updated = $model->updateEvent($id, $data);
        $this->flash($updated ? 'success' : 'error', $updated ? 'Evenement mis a jour avec succes.' : 'Impossible de mettre a jour cet evenement.');
        $this->redirect('evenement');
    }

    public function delete(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->flash('error', 'Evenement introuvable.');
            $this->redirect('evenement');
        }

        $model = new Evenement();
        $deleted = $model->softDelete($id);
        $this->flash($deleted ? 'success' : 'error', $deleted ? 'Evenement supprime avec succes.' : 'Impossible de supprimer cet evenement.');
        $this->redirect('evenement');
    }

    public function addMedia(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $data = $this->validatedMediaData();
        if ($data === null) {
            $this->redirect('evenement');
        }

        $model = new MediaEvenement();
        if ($model->countByEvenementId($data['evenement_id']) >= self::MAX_MEDIA_PER_EVENT) {
            $this->flash('error', 'Cet evenement a deja 3 medias.');
            $this->redirect('evenement');
        }

        $created = $model->createMedia($data);
        $this->flash($created ? 'success' : 'error', $created ? 'Media ajoute avec succes.' : 'Impossible d’ajouter ce media.');
        $this->redirect('evenement');
    }

    public function deleteMedia(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->flash('error', 'Media introuvable.');
            $this->redirect('evenement');
        }

        $model = new MediaEvenement();
        $deleted = $model->softDelete($id);
        $this->flash($deleted ? 'success' : 'error', $deleted ? 'Media supprime avec succes.' : 'Impossible de supprimer ce media.');
        $this->redirect('evenement');
    }

    private function validatedEventData(): ?array
    {
        $titre = trim((string)($_POST['titre'] ?? ''));
        $description = trim((string)($_POST['description'] ?? ''));
        $dateDebut = trim((string)($_POST['date_debut'] ?? ''));
        $dateFin = trim((string)($_POST['date_fin'] ?? ''));
        $lieu = trim((string)($_POST['lieu'] ?? ''));
        $type = trim((string)($_POST['type_evenement'] ?? 'Interne'));
        $clientId = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT) ?: null;

        if ($titre === '' || $dateDebut === '' || $dateFin === '' || $lieu === '') {
            $this->flash('error', 'Titre, dates et lieu sont obligatoires.');
            return null;
        }

        if (!in_array($type, self::ALLOWED_TYPES, true)) {
            $this->flash('error', 'Type d’evenement invalide.');
            return null;
        }

        $start = strtotime($dateDebut);
        $end = strtotime($dateFin);
        if ($start === false || $end === false || $end < $start) {
            $this->flash('error', 'Dates invalides.');
            return null;
        }

        if ($type === 'Interne') {
            $clientId = null;
        }

        return [
            'titre' => $titre,
            'description' => $description,
            'date_debut' => date('Y-m-d H:i:s', $start),
            'date_fin' => date('Y-m-d H:i:s', $end),
            'lieu' => $lieu,
            'type_evenement' => $type,
            'client_id' => $clientId,
        ];
    }

    private function validatedMediaData(): ?array
    {
        $eventId = filter_input(INPUT_POST, 'evenement_id', FILTER_VALIDATE_INT);
        $typeMedia = trim((string)($_POST['type_media'] ?? ''));

        if (!$eventId) {
            $this->flash('error', 'Evenement obligatoire.');
            return null;
        }

        if (!in_array($typeMedia, self::ALLOWED_MEDIA_TYPES, true)) {
            $this->flash('error', 'Type de media invalide.');
            return null;
        }

        $uploadedPath = $this->storeUploadedImage();
        if ($uploadedPath === null) {
            return null;
        }

        return [
            'evenement_id' => $eventId,
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

        $uploadDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'evenements';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
            $this->flash('error', 'Impossible de creer le dossier upload.');
            return null;
        }

        $extension = self::ALLOWED_IMAGE_TYPES[$mimeType];
        $fileName = 'event_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
        $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

        if (!move_uploaded_file((string)$file['tmp_name'], $targetPath)) {
            $this->flash('error', 'Impossible d’enregistrer l’image.');
            return null;
        }

        return 'uploads/evenements/' . $fileName;
    }

    private function requirePost(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('evenement');
        }
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION['toast'] = ['type' => $type, 'message' => $message];
    }
}
