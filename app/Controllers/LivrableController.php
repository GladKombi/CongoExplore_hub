<?php
require_once __DIR__ . '/../Models/Livrable.php';
require_once __DIR__ . '/../Models/ProjetMarketing.php';

class LivrableController extends Controller
{
    private const STATUSES = ['A faire', 'En cours', 'Valide', 'Bloque'];

    public function index(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $deliverableModel = new Livrable();
        $projectModel = new ProjetMarketing();

        $this->view('livrables/index', [
            'title' => 'Livrables',
            'livrables' => $deliverableModel->findAllWithProject(),
            'projets' => $projectModel->findAllWithClient(),
        ]);
    }

    public function create(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();
        $data = $this->validatedDeliverableData();
        if ($data === null) $this->redirect('livrable');

        $model = new Livrable();
        $created = $model->createDeliverable($data);
        $this->flash($created ? 'success' : 'error', $created ? 'Livrable cree avec succes.' : 'Impossible de creer ce livrable.');
        $this->redirect('livrable');
    }

    public function update(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $data = $this->validatedDeliverableData();
        if (!$id || $data === null) $this->redirect('livrable');

        $model = new Livrable();
        $updated = $model->updateDeliverable($id, $data);
        $this->flash($updated ? 'success' : 'error', $updated ? 'Livrable mis a jour avec succes.' : 'Impossible de mettre a jour ce livrable.');
        $this->redirect('livrable');
    }

    public function delete(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) $this->redirect('livrable');

        $model = new Livrable();
        $deleted = $model->softDelete($id);
        $this->flash($deleted ? 'success' : 'error', $deleted ? 'Livrable supprime avec succes.' : 'Impossible de supprimer ce livrable.');
        $this->redirect('livrable');
    }

    private function validatedDeliverableData(): ?array
    {
        $title = trim((string)($_POST['titre'] ?? ''));
        $description = trim((string)($_POST['description'] ?? ''));
        $dueDate = trim((string)($_POST['date_echeance'] ?? ''));
        $status = trim((string)($_POST['statut'] ?? 'A faire'));
        $projectId = filter_input(INPUT_POST, 'projet_id', FILTER_VALIDATE_INT);

        if ($title === '' || $dueDate === '' || !$projectId || !in_array($status, self::STATUSES, true)) {
            $this->flash('error', 'Champs livrable invalides.');
            return null;
        }

        return [
            'titre' => $title,
            'description' => $description,
            'date_echeance' => $dueDate,
            'statut' => $status,
            'projet_id' => $projectId,
        ];
    }

    private function requirePost(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') $this->redirect('livrable');
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION['toast'] = ['type' => $type, 'message' => $message];
    }
}
