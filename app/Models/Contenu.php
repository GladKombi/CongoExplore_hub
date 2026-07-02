<?php

class Contenu extends Model
{
    protected string $table = 'contenus';
    private array $knownTables = [];

    public function findAllWithRelations(): array
    {
        $stmt = $this->db->query(
            $this->baseRelationSelect() . "
             FROM contenus c
             LEFT JOIN categories cat ON cat.id = c.categorie_id
             LEFT JOIN utilisateurs u ON u.id = c.auteur_id
             WHERE c.supprimer = 0
             ORDER BY c.created_at DESC"
        );

        return $stmt->fetchAll();
    }

    public function findByIdWithRelations(int $id): ?array
    {
        $stmt = $this->db->prepare(
            $this->baseRelationSelect() . "
             FROM contenus c
             LEFT JOIN categories cat ON cat.id = c.categorie_id
             LEFT JOIN utilisateurs u ON u.id = c.auteur_id
             WHERE c.id = :id AND c.supprimer = 0"
        );
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function findCategories(): array
    {
        $stmt = $this->db->query('SELECT * FROM categories WHERE supprimer = 0 ORDER BY nom ASC');
        return $stmt->fetchAll();
    }

    public function findPublished(): array
    {
        $stmt = $this->db->query(
            $this->baseRelationSelect() . "
             FROM contenus c
             LEFT JOIN categories cat ON cat.id = c.categorie_id
             LEFT JOIN utilisateurs u ON u.id = c.auteur_id
             WHERE c.statut = 'Publie' AND c.supprimer = 0
             ORDER BY c.date_publication DESC"
        );

        return $stmt->fetchAll();
    }

    public function createContent(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO contenus (titre, corps_text, statut, categorie_id, auteur_id, date_publication)
             VALUES (:titre, :corps_text, :statut, :categorie_id, :auteur_id, :date_publication)'
        );

        return $stmt->execute([
            'titre' => $data['titre'],
            'corps_text' => $data['corps_text'],
            'statut' => $data['statut'],
            'categorie_id' => $data['categorie_id'],
            'auteur_id' => $data['auteur_id'],
            'date_publication' => $data['date_publication'],
        ]);
    }

    public function updateContent(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE contenus
             SET titre = :titre,
                 corps_text = :corps_text,
                 statut = :statut,
                 categorie_id = :categorie_id,
                 date_publication = :date_publication
             WHERE id = :id AND supprimer = 0'
        );

        return $stmt->execute([
            'id' => $id,
            'titre' => $data['titre'],
            'corps_text' => $data['corps_text'],
            'statut' => $data['statut'],
            'categorie_id' => $data['categorie_id'],
            'date_publication' => $data['date_publication'],
        ]);
    }

    public function softDelete(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE contenus SET supprimer = 1 WHERE id = :id AND supprimer = 0');
        return $stmt->execute(['id' => $id]);
    }

    private function baseRelationSelect(): string
    {
        return "SELECT c.*, cat.nom AS categorie_nom, u.nom AS auteur_nom, u.prenom AS auteur_prenom,
                    {$this->countSelect('commentaires', 'cm', 'commentaires_count')},
                    {$this->countSelect('likes', 'lk', 'likes_count')},
                    {$this->countSelect('partages', 'sh', 'partages_count')},
                    {$this->countSelect('favoris', 'fav', 'favoris_count')},
                    (SELECT mg.url_fichier FROM media_galleries mg WHERE mg.contenu_id = c.id AND mg.supprimer = 0 ORDER BY mg.date_creation ASC LIMIT 1) AS media_url";
    }

    private function countSelect(string $table, string $alias, string $columnAlias): string
    {
        if (!$this->tableExists($table)) {
            return "0 AS {$columnAlias}";
        }

        return "(SELECT COUNT(*) FROM {$table} {$alias} WHERE {$alias}.contenu_id = c.id AND {$alias}.supprimer = 0) AS {$columnAlias}";
    }

    private function tableExists(string $table): bool
    {
        if (array_key_exists($table, $this->knownTables)) {
            return $this->knownTables[$table];
        }

        try {
            $stmt = $this->db->prepare(
                'SELECT COUNT(*)
                 FROM INFORMATION_SCHEMA.TABLES
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = :table_name'
            );
            $stmt->execute(['table_name' => $table]);
            $this->knownTables[$table] = ((int)$stmt->fetchColumn()) > 0;
        } catch (PDOException $e) {
            $this->knownTables[$table] = false;
        }

        return $this->knownTables[$table];
    }
}
