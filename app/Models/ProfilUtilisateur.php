<?php

class ProfilUtilisateur extends Model
{
    protected string $table = 'profils_utilisateurs';

    public function findByUtilisateurId(int $utilisateurId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM profils_utilisateurs WHERE utilisateur_id = :uid');
        $stmt->execute(['uid' => $utilisateurId]);
        return $stmt->fetch() ?: null;
    }
}
