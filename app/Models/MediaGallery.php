<?php

class MediaGallery extends Model
{
    protected string $table = 'media_galleries';

    public function __construct()
    {
        parent::__construct();
        $this->ensureMultiMediaSchema();
    }

    public function findAllWithContent(): array
    {
        $stmt = $this->db->query(
            "SELECT m.*, c.titre AS contenu_titre, c.statut AS contenu_statut
             FROM media_galleries m
             LEFT JOIN contenus c ON c.id = m.contenu_id
             WHERE m.supprimer = 0
             ORDER BY m.date_creation DESC"
        );

        return $stmt->fetchAll();
    }

    public function findByContenuId(int $contenuId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM media_galleries WHERE contenu_id = :cid AND supprimer = 0');
        $stmt->execute(['cid' => $contenuId]);
        return $stmt->fetchAll();
    }

    public function countByContenuId(int $contenuId): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM media_galleries WHERE contenu_id = :cid AND supprimer = 0');
        $stmt->execute(['cid' => $contenuId]);
        return (int)$stmt->fetchColumn();
    }

    public function createMedia(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO media_galleries (contenu_id, type_media, url_fichier)
             VALUES (:contenu_id, :type_media, :url_fichier)'
        );

        return $stmt->execute([
            'contenu_id' => $data['contenu_id'],
            'type_media' => $data['type_media'],
            'url_fichier' => $data['url_fichier'],
        ]);
    }

    public function softDelete(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE media_galleries SET supprimer = 1 WHERE id = :id AND supprimer = 0');
        return $stmt->execute(['id' => $id]);
    }

    private function ensureMultiMediaSchema(): void
    {
        try {
            $columns = $this->db->query('SHOW COLUMNS FROM media_galleries')->fetchAll();
            $hasId = false;

            foreach ($columns as $column) {
                if (($column['Field'] ?? '') === 'id') {
                    $hasId = true;
                    break;
                }
            }

            if ($hasId) {
                return;
            }

            $this->db->exec('ALTER TABLE media_galleries DROP PRIMARY KEY');
            $this->db->exec('ALTER TABLE media_galleries ADD id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
            $this->db->exec('CREATE INDEX idx_media_galleries_contenu_id ON media_galleries (contenu_id)');
        } catch (PDOException $e) {
            // The controller will surface the original database error if migration is not allowed.
        }
    }
}
