<?php

class Livrable extends Model
{
    protected string $table = 'livrables';

    public function findAllWithProject(): array
    {
        $stmt = $this->db->query(
            "SELECT l.*, p.nom AS projet_nom, c.nom_entreprise AS client_nom
             FROM livrables l
             LEFT JOIN projets_marketing p ON p.id = l.projet_id
             LEFT JOIN clients c ON c.id = p.client_id
             WHERE l.supprimer = 0
             ORDER BY l.date_echeance ASC"
        );
        return $stmt->fetchAll();
    }

    public function findByProjetId(int $projetId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM livrables WHERE projet_id = :pid AND supprimer = 0');
        $stmt->execute(['pid' => $projetId]);
        return $stmt->fetchAll();
    }

    public function createDeliverable(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO livrables (titre, description, date_echeance, statut, projet_id)
             VALUES (:titre, :description, :date_echeance, :statut, :projet_id)'
        );
        return $stmt->execute($data);
    }

    public function updateDeliverable(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE livrables
             SET titre = :titre,
                 description = :description,
                 date_echeance = :date_echeance,
                 statut = :statut,
                 projet_id = :projet_id
             WHERE id = :id AND supprimer = 0'
        );
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function softDelete(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE livrables SET supprimer = 1 WHERE id = :id AND supprimer = 0');
        return $stmt->execute(['id' => $id]);
    }
}
