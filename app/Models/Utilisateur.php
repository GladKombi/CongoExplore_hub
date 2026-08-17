<?php

class Utilisateur extends Model
{
    protected string $table = 'utilisateurs';

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT u.*, p.photo_profil
             FROM utilisateurs u
             LEFT JOIN profils_utilisateurs p ON p.utilisateur_id = u.id
             WHERE u.email = :email AND u.supprimer = 0'
        );
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public function findAllWithProfiles(): array
    {
        $sql = 'SELECT u.*, p.photo_profil
                FROM utilisateurs u
                LEFT JOIN profils_utilisateurs p ON p.utilisateur_id = u.id
                WHERE u.supprimer = 0
                ORDER BY u.date_creation DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function findByIdWithProfile(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT u.*, p.photo_profil, p.biographie, p.secteur, p.liens_reseaux
             FROM utilisateurs u
             LEFT JOIN profils_utilisateurs p ON p.utilisateur_id = u.id
             WHERE u.id = :id AND u.supprimer = 0'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = 'SELECT COUNT(*) FROM utilisateurs WHERE email = :email AND supprimer = 0';
        $params = ['email' => $email];

        if ($excludeId !== null) {
            $sql .= ' AND id != :id';
            $params['id'] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn() > 0;
    }

    public function createUser(array $data): int|false
    {
        $stmt = $this->db->prepare(
            'INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role)
             VALUES (:nom, :prenom, :email, :mot_de_passe, :role)'
        );

        $created = $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'mot_de_passe' => $data['mot_de_passe'],
            'role' => $data['role'],
        ]);

        return $created ? (int)$this->db->lastInsertId() : false;
    }

    public function updateUser(int $id, array $data): bool
    {
        $fields = [
            'nom = :nom',
            'prenom = :prenom',
            'email = :email',
            'role = :role',
        ];

        $params = [
            'id' => $id,
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'role' => $data['role'],
        ];

        if (!empty($data['mot_de_passe'])) {
            $fields[] = 'mot_de_passe = :mot_de_passe';
            $params['mot_de_passe'] = $data['mot_de_passe'];
        }

        $sql = 'UPDATE utilisateurs SET ' . implode(', ', $fields) . ' WHERE id = :id AND supprimer = 0';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    public function softDelete(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE utilisateurs SET supprimer = 1 WHERE id = :id AND supprimer = 0');
        return $stmt->execute(['id' => $id]);
    }
}
