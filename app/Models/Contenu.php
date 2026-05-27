<?php

class Contenu extends Model
{
    protected string $table = 'contenus';

    public function findPublished(): array
    {
        $stmt = $this->db->query("SELECT * FROM contenus WHERE statut = 'Publie' AND supprimer = 0 ORDER BY date_publication DESC");
        return $stmt->fetchAll();
    }
}
