<?php
require_once __DIR__ . '/../Models/Categorie.php';

class CategorieController extends Controller
{
    public function index(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $model = new Categorie();
        $categories = $model->findAll();
        $this->view('categories/index', ['title' => 'Categories', 'categories' => $categories]);
    }

    public function create(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $nom = $this->validatedName();
        if ($nom === null) {
            $this->redirect('categorie');
        }

        $model = new Categorie();
        if ($model->nameExists($nom)) {
            $this->flash('error', 'Cette categorie existe deja.');
            $this->redirect('categorie');
        }

        $created = $model->createCategory($nom);
        $this->flash($created ? 'success' : 'error', $created ? 'Categorie creee avec succes.' : 'Impossible de creer cette categorie.');
        $this->redirect('categorie');
    }

    public function update(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nom = $this->validatedName();

        if (!$id || $nom === null) {
            $this->flash('error', 'Categorie introuvable.');
            $this->redirect('categorie');
        }

        $model = new Categorie();
        if ($model->nameExists($nom, $id)) {
            $this->flash('error', 'Cette categorie existe deja.');
            $this->redirect('categorie');
        }

        $updated = $model->updateCategory($id, $nom);
        $this->flash($updated ? 'success' : 'error', $updated ? 'Categorie mise a jour avec succes.' : 'Impossible de mettre a jour cette categorie.');
        $this->redirect('categorie');
    }

    public function delete(): void
    {
        $this->requireRole(['Admin', 'Journaliste', 'Community Manager']);
        $this->requirePost();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->flash('error', 'Categorie introuvable.');
            $this->redirect('categorie');
        }

        $model = new Categorie();
        $deleted = $model->softDelete($id);
        $this->flash($deleted ? 'success' : 'error', $deleted ? 'Categorie supprimee avec succes.' : 'Impossible de supprimer cette categorie.');
        $this->redirect('categorie');
    }

    private function validatedName(): ?string
    {
        $nom = trim((string)($_POST['nom'] ?? ''));
        if ($nom === '' || strlen($nom) < 2) {
            $this->flash('error', 'Le nom de la categorie doit contenir au moins 2 caracteres.');
            return null;
        }

        return $nom;
    }

    private function requirePost(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('categorie');
        }
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION['toast'] = ['type' => $type, 'message' => $message];
    }
}
