<?php

class MediaGallery extends Model
{
    protected string $table = 'media_galleries';

    public function findByContenuId(int $contenuId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM media_galleries WHERE contenu_id = :cid AND supprimer = 0');
        $stmt->execute(['cid' => $contenuId]);
        return $stmt->fetch() ?: null;
    }
}
