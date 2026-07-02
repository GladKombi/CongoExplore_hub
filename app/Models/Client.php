<?php

class Client extends Model
{
    protected string $table = 'clients';

    public function createClient(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO clients (nom_entreprise, secteur_activite, email_contact, telephone, adresse)
             VALUES (:nom_entreprise, :secteur_activite, :email_contact, :telephone, :adresse)'
        );

        return $stmt->execute($data);
    }

    public function updateClient(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE clients
             SET nom_entreprise = :nom_entreprise,
                 secteur_activite = :secteur_activite,
                 email_contact = :email_contact,
                 telephone = :telephone,
                 adresse = :adresse
             WHERE id = :id AND supprimer = 0'
        );

        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function softDelete(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE clients SET supprimer = 1 WHERE id = :id AND supprimer = 0');
        return $stmt->execute(['id' => $id]);
    }
}
