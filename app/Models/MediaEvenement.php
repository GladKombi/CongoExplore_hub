<?php

class MediaEvenement extends Model
{
    protected string $table = 'media_evenements';

    public function findAllWithEvent(): array
    {
        $stmt = $this->db->query(
            "SELECT m.*, e.titre AS evenement_titre, e.date_debut AS evenement_date
             FROM media_evenements m
             LEFT JOIN evenements e ON e.id = m.evenement_id
             WHERE m.supprimer = 0
             ORDER BY m.date_creation DESC"
        );

        return $stmt->fetchAll();
    }

    public function findByEvenementId(int $evenementId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM media_evenements WHERE evenement_id = :eid AND supprimer = 0');
        $stmt->execute(['eid' => $evenementId]);
        return $stmt->fetchAll();
    }

    public function countByEvenementId(int $evenementId): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM media_evenements WHERE evenement_id = :eid AND supprimer = 0');
        $stmt->execute(['eid' => $evenementId]);
        return (int)$stmt->fetchColumn();
    }

    public function createMedia(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO media_evenements (evenement_id, type_media, url_fichier)
             VALUES (:evenement_id, :type_media, :url_fichier)'
        );

        return $stmt->execute([
            'evenement_id' => $data['evenement_id'],
            'type_media' => $data['type_media'],
            'url_fichier' => $data['url_fichier'],
        ]);
    }

    public function softDelete(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE media_evenements SET supprimer = 1 WHERE id = :id AND supprimer = 0');
        return $stmt->execute(['id' => $id]);
    }
}
