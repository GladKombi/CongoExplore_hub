<?php

class ProjetMarketing extends Model
{
    protected string $table = 'projets_marketing';

    public function findActive(): array
    {
        $stmt = $this->db->query("SELECT * FROM projets_marketing WHERE statut IN ('En attente','En cours') AND supprimer = 0");
        return $stmt->fetchAll();
    }
}
