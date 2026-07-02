<?php

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();

        $stats = [
            'utilisateurs' => $this->countActive('utilisateurs'),
            'contenus' => $this->countActive('contenus'),
            'categories' => $this->countActive('categories'),
            'medias' => $this->countActive('media_galleries'),
            'evenements' => $this->countActive('evenements'),
            'clients' => $this->countActive('clients'),
            'projets' => $this->countActive('projets_marketing'),
            'livrables' => $this->countActive('livrables'),
            'commentaires' => $this->countActive('commentaires'),
            'likes' => $this->countActive('likes'),
            'partages' => $this->countActive('partages'),
        ];

        $this->view('dashboard/index', [
            'title' => 'Tableau de bord',
            'stats' => $stats,
            'recentContents' => $this->recentContents(),
            'recentEvents' => $this->recentEvents(),
        ]);
    }

    private function countActive(string $table): int
    {
        if (!$this->tableExists($table)) {
            return 0;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT COUNT(*) FROM {$table} WHERE supprimer = 0");
        return (int)$stmt->fetchColumn();
    }

    private function recentContents(): array
    {
        if (!$this->tableExists('contenus')) {
            return [];
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->query(
            "SELECT c.id, c.titre, c.statut, c.created_at, cat.nom AS categorie_nom
             FROM contenus c
             LEFT JOIN categories cat ON cat.id = c.categorie_id
             WHERE c.supprimer = 0
             ORDER BY c.created_at DESC
             LIMIT 5"
        );

        return $stmt->fetchAll();
    }

    private function recentEvents(): array
    {
        if (!$this->tableExists('evenements')) {
            return [];
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->query(
            "SELECT id, titre, lieu, date_debut, type_evenement
             FROM evenements
             WHERE supprimer = 0
             ORDER BY date_debut DESC
             LIMIT 5"
        );

        return $stmt->fetchAll();
    }

    private function tableExists(string $table): bool
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare(
                'SELECT COUNT(*)
                 FROM INFORMATION_SCHEMA.TABLES
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = :table_name'
            );
            $stmt->execute(['table_name' => $table]);
            return ((int)$stmt->fetchColumn()) > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
