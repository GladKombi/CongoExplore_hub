<?php
require_once __DIR__ . '/../Models/Evenement.php';

class EvenementController extends Controller
{
    public function index(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $model = new Evenement();
        $evenements = $model->findAll();
        $this->view('evenements/index', ['title' => 'Événements', 'evenements' => $evenements]);
    }

    public function show(int $id): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $model = new Evenement();
        $evenement = $model->findById($id);
        $this->view('evenements/show', ['title' => 'Événement', 'evenement' => $evenement]);
    }
}
