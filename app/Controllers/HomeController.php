<?php
require_once __DIR__ . '/../Models/Contenu.php';

class HomeController extends Controller
{
    public function index(): void
    {
        $model = new Contenu();
        $contenus = $model->findPublished();

        if (empty($contenus)) {
            $contenus = $model->findAllWithRelations();
        }

        $categories = $model->findCategories();
        $this->render('home/index', ['homeContents' => $contenus, 'homeCategories' => $categories]);
    }
}
