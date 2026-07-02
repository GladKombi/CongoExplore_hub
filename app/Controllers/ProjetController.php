<?php
require_once __DIR__ . '/../Models/ProjetMarketing.php';
require_once __DIR__ . '/../Models/Client.php';
require_once __DIR__ . '/../Models/Livrable.php';

class ProjetController extends Controller
{
    private const TYPES = ['Digital', 'Physique', 'Influence', 'Street Marketing', '360'];
    private const STATUSES = ['En attente', 'En cours', 'Termine', 'Annule'];

    public function index(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $projectModel = new ProjetMarketing();
        $clientModel = new Client();
        $deliverableModel = new Livrable();

        $this->view('projets/index', [
            'title' => 'Projets marketing',
            'projets' => $projectModel->findAllWithClient(),
            'clients' => $clientModel->findAll(),
            'livrables' => $deliverableModel->findAllWithProject(),
        ]);
    }

    public function show(int $id): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $projectModel = new ProjetMarketing();
        $deliverableModel = new Livrable();

        $this->view('projets/show', [
            'title' => 'Projet marketing',
            'projet' => $projectModel->findByIdWithClient($id),
            'livrables' => $deliverableModel->findByProjetId($id),
        ]);
    }

    public function create(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();
        $data = $this->validatedProjectData();
        if ($data === null) $this->redirect('projet');

        $model = new ProjetMarketing();
        $created = $model->createProject($data);
        $this->flash($created ? 'success' : 'error', $created ? 'Projet cree avec succes.' : 'Impossible de creer ce projet.');
        $this->redirect('projet');
    }

    public function update(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $data = $this->validatedProjectData();
        if (!$id || $data === null) $this->redirect('projet');

        $model = new ProjetMarketing();
        $updated = $model->updateProject($id, $data);
        $this->flash($updated ? 'success' : 'error', $updated ? 'Projet mis a jour avec succes.' : 'Impossible de mettre a jour ce projet.');
        $this->redirect('projet');
    }

    public function delete(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) $this->redirect('projet');

        $model = new ProjetMarketing();
        $deleted = $model->softDelete($id);
        $this->flash($deleted ? 'success' : 'error', $deleted ? 'Projet supprime avec succes.' : 'Impossible de supprimer ce projet.');
        $this->redirect('projet');
    }

    private function validatedProjectData(): ?array
    {
        $name = trim((string)($_POST['nom'] ?? ''));
        $type = trim((string)($_POST['type_campagne'] ?? ''));
        $budget = (float)($_POST['budget'] ?? 0);
        $start = trim((string)($_POST['date_debut'] ?? ''));
        $end = trim((string)($_POST['date_fin'] ?? ''));
        $status = trim((string)($_POST['statut'] ?? 'En attente'));
        $clientId = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);

        if ($name === '' || !$clientId || !in_array($type, self::TYPES, true) || !in_array($status, self::STATUSES, true)) {
            $this->flash('error', 'Champs projet invalides.');
            return null;
        }

        return [
            'nom' => $name,
            'type_campagne' => $type,
            'budget' => $budget,
            'date_debut' => $start !== '' ? $start : null,
            'date_fin' => $end !== '' ? $end : null,
            'statut' => $status,
            'client_id' => $clientId,
        ];
    }

    private function requirePost(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') $this->redirect('projet');
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION['toast'] = ['type' => $type, 'message' => $message];
    }
}
