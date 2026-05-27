<?php

class Utilisateur extends Model
{
    protected string $table = 'utilisateurs';

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM utilisateurs WHERE email = :email AND supprimer = 0');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }
}
