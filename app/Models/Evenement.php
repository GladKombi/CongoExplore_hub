<?php

class Evenement extends Model
{
    protected string $table = 'evenements';

    public function findClientEvents(int $clientId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM evenements WHERE client_id = :cid AND supprimer = 0');
        $stmt->execute(['cid' => $clientId]);
        return $stmt->fetchAll();
    }
}
