<?php

class Livrable extends Model
{
    protected string $table = 'livrables';

    public function findByProjetId(int $projetId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM livrables WHERE projet_id = :pid AND supprimer = 0');
        $stmt->execute(['pid' => $projetId]);
        return $stmt->fetchAll();
    }
}
