<?php
require_once __DIR__ . '/../Models/Utilisateur.php';

class UtilisateurController extends Controller
{
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
}
