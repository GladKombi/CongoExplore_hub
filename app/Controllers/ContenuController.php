<?php
require_once __DIR__ . '/../Models/Contenu.php';
require_once __DIR__ . '/../Models/ContenuEngagement.php';
require_once __DIR__ . '/../Models/MediaGallery.php';

class ContenuController extends Controller
{
    private const ALLOWED_STATUSES = ['Brouillon', 'Publie', 'Archive'];

    public function index(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $model = new Contenu();
        $contenus = $model->findAllWithRelations();
        $categories = $model->findCategories();
        $this->view('contenus/index', ['title' => 'Publications', 'contenus' => $contenus, 'categories' => $categories]);
    }

    public function show(int $id): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $model = new Contenu();
        $engagement = new ContenuEngagement();
        $contenu = $model->findByIdWithRelations($id);
        $comments = $contenu ? $engagement->commentsForContent($id) : [];
        $this->view('contenus/show', ['title' => 'Publication', 'contenu' => $contenu, 'commentaires' => $comments]);
    }

    public function detail(int $id): void
    {
        $model = new Contenu();
        $engagement = new ContenuEngagement();
        $mediaModel = new MediaGallery();
        $contenu = $model->findByIdWithRelations($id);
        $comments = $contenu ? $engagement->commentsForContent($id) : [];
        $categories = $model->findCategories();
        $medias = $contenu ? $mediaModel->findByContenuId($id) : [];

        $this->render('contenus/detail', [
            'title' => $contenu['titre'] ?? 'Publication',
            'contenu' => $contenu,
            'commentaires' => $comments,
            'categories' => $categories,
            'medias' => $medias,
        ]);
    }

    public function create(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $data = $this->validatedContentData();
        if ($data === null) {
            $this->redirect('contenu');
        }

        $user = $_SESSION['user'] ?? [];
        $data['auteur_id'] = (int)($user['id'] ?? 0);

        if ($data['auteur_id'] <= 0) {
            $this->flash('error', 'Auteur introuvable. Reconnectez-vous.');
            $this->redirect('contenu');
        }

        $model = new Contenu();
        if ($model->createContent($data)) {
            $this->flash('success', 'Publication creee avec succes.');
        } else {
            $this->flash('error', 'Impossible de creer cette publication.');
        }

        $this->redirect('contenu');
    }

    public function update(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->flash('error', 'Publication introuvable.');
            $this->redirect('contenu');
        }

        $data = $this->validatedContentData();
        if ($data === null) {
            $this->redirect('contenu');
        }

        $model = new Contenu();
        if (!$model->findById($id)) {
            $this->flash('error', 'Publication introuvable.');
            $this->redirect('contenu');
        }

        if ($model->updateContent($id, $data)) {
            $this->flash('success', 'Publication mise a jour avec succes.');
        } else {
            $this->flash('error', 'Impossible de mettre a jour cette publication.');
        }

        $this->redirect('contenu');
    }

    public function delete(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->flash('error', 'Publication introuvable.');
            $this->redirect('contenu');
        }

        $model = new Contenu();
        if ($model->softDelete($id)) {
            $this->flash('success', 'Publication supprimee avec succes.');
        } else {
            $this->flash('error', 'Impossible de supprimer cette publication.');
        }

        $this->redirect('contenu');
    }

    public function comment(): void
    {
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'contenu_id', FILTER_VALIDATE_INT);
        $comment = trim((string)($_POST['commentaire'] ?? ''));

        if ($id && $comment !== '') {
            $engagement = new ContenuEngagement();
            $engagement->addComment($id, $comment, $this->ipAddress());
        }

        $this->redirectBack();
    }

    public function like(): void
    {
        $this->requirePost();
        $id = filter_input(INPUT_POST, 'contenu_id', FILTER_VALIDATE_INT);

        if ($id) {
            $engagement = new ContenuEngagement();
            $engagement->toggleLike($id, $this->ipAddress());
        }

        $this->redirectBack();
    }

    public function favorite(): void
    {
        $this->requirePost();
        $id = filter_input(INPUT_POST, 'contenu_id', FILTER_VALIDATE_INT);

        if ($id) {
            $engagement = new ContenuEngagement();
            $engagement->toggleFavorite($id, $this->ipAddress());
        }

        $this->redirectBack();
    }

    public function share(): void
    {
        $this->requirePost();
        $id = filter_input(INPUT_POST, 'contenu_id', FILTER_VALIDATE_INT);
        $platform = trim((string)($_POST['plateforme'] ?? 'Facebook'));
        $allowed = ['Facebook', 'Twitter', 'LinkedIn', 'WhatsApp', 'Email'];

        if ($id && in_array($platform, $allowed, true)) {
            $engagement = new ContenuEngagement();
            $engagement->addShare($id, $platform, $this->ipAddress());
        }

        $this->redirectBack();
    }

    public function deleteComment(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $engagement = new ContenuEngagement();
            $engagement->softDeleteComment($id);
            $this->flash('success', 'Commentaire supprime.');
        }

        $this->redirectBack('contenu');
    }

    private function requirePost(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('contenu');
        }
    }

    private function validatedContentData(): ?array
    {
        $titre = trim((string)($_POST['titre'] ?? ''));
        $corpsText = trim((string)($_POST['corps_text'] ?? ''));
        $statut = trim((string)($_POST['statut'] ?? 'Brouillon'));
        $categorieId = filter_input(INPUT_POST, 'categorie_id', FILTER_VALIDATE_INT);
        $datePublication = trim((string)($_POST['date_publication'] ?? ''));

        if ($titre === '' || $corpsText === '' || !$categorieId) {
            $this->flash('error', 'Titre, contenu et categorie sont obligatoires.');
            return null;
        }

        if (!in_array($statut, self::ALLOWED_STATUSES, true)) {
            $this->flash('error', 'Statut invalide.');
            return null;
        }

        if ($datePublication !== '') {
            $timestamp = strtotime($datePublication);
            if ($timestamp === false) {
                $this->flash('error', 'Date de publication invalide.');
                return null;
            }
            $datePublication = date('Y-m-d H:i:s', $timestamp);
        } elseif ($statut === 'Publie') {
            $datePublication = date('Y-m-d H:i:s');
        } else {
            $datePublication = null;
        }

        return [
            'titre' => $titre,
            'corps_text' => $corpsText,
            'statut' => $statut,
            'categorie_id' => $categorieId,
            'date_publication' => $datePublication,
        ];
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION['toast'] = [
            'type' => $type,
            'message' => $message,
        ];
    }

    private function ipAddress(): ?string
    {
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }

    private function redirectBack(string $fallback = ''): void
    {
        $target = $_SERVER['HTTP_REFERER'] ?? (BASE_URL . ltrim($fallback, '/'));
        header('Location: ' . $target);
        exit;
    }
}
