<?php
require_once __DIR__ . '/../Models/Contenu.php';

class ContenuController extends Controller
{
    public function index(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $model = new Contenu();
        $contenus = $model->findAll();
        $this->view('contenus/index', ['title' => 'Contenus', 'contenus' => $contenus]);
    }

    public function show(int $id): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $model = new Contenu();
        $contenu = $model->findById($id);
        $this->view('contenus/show', ['title' => 'Contenu', 'contenu' => $contenu]);
    }
}
