<?php

class MediaEvenement extends Model
{
    protected string $table = 'media_evenements';

    public function findByEvenementId(int $evenementId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM media_evenements WHERE evenement_id = :eid AND supprimer = 0');
        $stmt->execute(['eid' => $evenementId]);
        return $stmt->fetchAll();
    }
}
