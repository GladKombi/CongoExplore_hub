<?php
require_once __DIR__ . '/../Models/Client.php';
require_once __DIR__ . '/../Models/ProjetMarketing.php';

class ClientController extends Controller
{
    public function index(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $clientModel = new Client();
        $projectModel = new ProjetMarketing();

        $this->view('clients/index', [
            'title' => 'Clients',
            'clients' => $clientModel->findAll(),
            'projets' => $projectModel->findAllWithClient(),
        ]);
    }

    public function show(int $id): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $clientModel = new Client();
        $projectModel = new ProjetMarketing();

        $client = $clientModel->findById($id);
        $projets = array_filter($projectModel->findAllWithClient(), static fn($p) => (int)($p['client_id'] ?? 0) === $id);

        $this->view('clients/show', ['title' => 'Client', 'client' => $client, 'projets' => $projets]);
    }

    public function create(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $data = $this->validatedClientData();
        if ($data === null) {
            $this->redirect('client');
        }

        $model = new Client();
        $created = $model->createClient($data);
        $this->flash($created ? 'success' : 'error', $created ? 'Client cree avec succes.' : 'Impossible de creer ce client.');
        $this->redirect('client');
    }

    public function update(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $data = $this->validatedClientData();
        if (!$id || $data === null) {
            $this->flash('error', 'Client introuvable.');
            $this->redirect('client');
        }

        $model = new Client();
        $updated = $model->updateClient($id, $data);
        $this->flash($updated ? 'success' : 'error', $updated ? 'Client mis a jour avec succes.' : 'Impossible de mettre a jour ce client.');
        $this->redirect('client');
    }

    public function delete(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->flash('error', 'Client introuvable.');
            $this->redirect('client');
        }

        $model = new Client();
        $deleted = $model->softDelete($id);
        $this->flash($deleted ? 'success' : 'error', $deleted ? 'Client supprime avec succes.' : 'Impossible de supprimer ce client.');
        $this->redirect('client');
    }

    private function validatedClientData(): ?array
    {
        $name = trim((string)($_POST['nom_entreprise'] ?? ''));
        $sector = trim((string)($_POST['secteur_activite'] ?? ''));
        $email = trim((string)($_POST['email_contact'] ?? ''));
        $phone = trim((string)($_POST['telephone'] ?? ''));
        $address = trim((string)($_POST['adresse'] ?? ''));

        if ($name === '' || $email === '') {
            $this->flash('error', 'Entreprise et email sont obligatoires.');
            return null;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->flash('error', 'Email invalide.');
            return null;
        }

        return [
            'nom_entreprise' => $name,
            'secteur_activite' => $sector,
            'email_contact' => $email,
            'telephone' => $phone,
            'adresse' => $address,
        ];
    }

    private function requirePost(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('client');
        }
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION['toast'] = ['type' => $type, 'message' => $message];
    }
}
