<?php
require_once __DIR__ . '/../Models/Client.php';

class ClientController extends Controller
{
    public function index(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $model = new Client();
        $clients = $model->findAll();
        $this->view('clients/index', ['title' => 'Clients', 'clients' => $clients]);
    }

    public function show(int $id): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $model = new Client();
        $client = $model->findById($id);
        $this->view('clients/show', ['title' => 'Client', 'client' => $client]);
    }
}
