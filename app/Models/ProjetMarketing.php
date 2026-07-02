<?php

class ProjetMarketing extends Model
{
    protected string $table = 'projets_marketing';

    public function findAllWithClient(): array
    {
        $stmt = $this->db->query(
            "SELECT p.*, c.nom_entreprise AS client_nom
             FROM projets_marketing p
             LEFT JOIN clients c ON c.id = p.client_id
             WHERE p.supprimer = 0
             ORDER BY p.created_at DESC"
        );
        return $stmt->fetchAll();
    }

    public function findByIdWithClient(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.nom_entreprise AS client_nom, c.email_contact AS client_email, c.telephone AS client_telephone
             FROM projets_marketing p
             LEFT JOIN clients c ON c.id = p.client_id
             WHERE p.id = :id AND p.supprimer = 0"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function findActive(): array
    {
        $stmt = $this->db->query("SELECT * FROM projets_marketing WHERE statut IN ('En attente','En cours') AND supprimer = 0");
        return $stmt->fetchAll();
    }

    public function createProject(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO projets_marketing (nom, type_campagne, budget, date_debut, date_fin, statut, client_id)
             VALUES (:nom, :type_campagne, :budget, :date_debut, :date_fin, :statut, :client_id)'
        );
        return $stmt->execute($data);
    }

    public function updateProject(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE projets_marketing
             SET nom = :nom,
                 type_campagne = :type_campagne,
                 budget = :budget,
                 date_debut = :date_debut,
                 date_fin = :date_fin,
                 statut = :statut,
                 client_id = :client_id
             WHERE id = :id AND supprimer = 0'
        );
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function softDelete(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE projets_marketing SET supprimer = 1 WHERE id = :id AND supprimer = 0');
        return $stmt->execute(['id' => $id]);
    }
}
