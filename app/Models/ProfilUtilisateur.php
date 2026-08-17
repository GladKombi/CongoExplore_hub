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

    public function savePhoto(int $utilisateurId, string $nomComplet, string $photoProfil): bool
    {
        $sql = 'INSERT INTO profils_utilisateurs (utilisateur_id, nom_complet, photo_profil, secteur)
                VALUES (:utilisateur_id, :nom_complet, :photo_profil, :secteur)
                ON DUPLICATE KEY UPDATE
                    nom_complet = VALUES(nom_complet),
                    photo_profil = VALUES(photo_profil)';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'utilisateur_id' => $utilisateurId,
            'nom_complet' => $nomComplet,
            'photo_profil' => $photoProfil,
            'secteur' => 'Autre',
        ]);
    }
}
