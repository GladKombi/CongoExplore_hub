<?php

class Evenement extends Model
{
    protected string $table = 'evenements';

    public function findAllWithClient(): array
    {
        $stmt = $this->db->query(
            "SELECT e.*, c.nom_entreprise AS client_nom
             FROM evenements e
             LEFT JOIN clients c ON c.id = e.client_id
             WHERE e.supprimer = 0
             ORDER BY e.date_debut DESC"
        );

        return $stmt->fetchAll();
    }

    public function findByIdWithClient(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT e.*, c.nom_entreprise AS client_nom, c.email_contact AS client_email, c.telephone AS client_telephone
             FROM evenements e
             LEFT JOIN clients c ON c.id = e.client_id
             WHERE e.id = :id AND e.supprimer = 0"
        );
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function findClientEvents(int $clientId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM evenements WHERE client_id = :cid AND supprimer = 0');
        $stmt->execute(['cid' => $clientId]);
        return $stmt->fetchAll();
    }

    public function createEvent(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO evenements (titre, description, date_debut, date_fin, lieu, type_evenement, client_id)
             VALUES (:titre, :description, :date_debut, :date_fin, :lieu, :type_evenement, :client_id)'
        );

        return $stmt->execute([
            'titre' => $data['titre'],
            'description' => $data['description'],
            'date_debut' => $data['date_debut'],
            'date_fin' => $data['date_fin'],
            'lieu' => $data['lieu'],
            'type_evenement' => $data['type_evenement'],
            'client_id' => $data['client_id'],
        ]);
    }

    public function updateEvent(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE evenements
             SET titre = :titre,
                 description = :description,
                 date_debut = :date_debut,
                 date_fin = :date_fin,
                 lieu = :lieu,
                 type_evenement = :type_evenement,
                 client_id = :client_id
             WHERE id = :id AND supprimer = 0'
        );

        return $stmt->execute([
            'id' => $id,
            'titre' => $data['titre'],
            'description' => $data['description'],
            'date_debut' => $data['date_debut'],
            'date_fin' => $data['date_fin'],
            'lieu' => $data['lieu'],
            'type_evenement' => $data['type_evenement'],
            'client_id' => $data['client_id'],
        ]);
    }

    public function softDelete(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE evenements SET supprimer = 1 WHERE id = :id AND supprimer = 0');
        return $stmt->execute(['id' => $id]);
    }
}
