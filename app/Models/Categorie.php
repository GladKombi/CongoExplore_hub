<?php

class Categorie extends Model
{
    protected string $table = 'categories';

    public function nameExists(string $nom, ?int $excludeId = null): bool
    {
        $sql = 'SELECT COUNT(*) FROM categories WHERE nom = :nom AND supprimer = 0';
        $params = ['nom' => $nom];

        if ($excludeId !== null) {
            $sql .= ' AND id != :id';
            $params['id'] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn() > 0;
    }

    public function createCategory(string $nom): bool
    {
        $stmt = $this->db->prepare('INSERT INTO categories (nom) VALUES (:nom)');
        return $stmt->execute(['nom' => $nom]);
    }

    public function updateCategory(int $id, string $nom): bool
    {
        $stmt = $this->db->prepare('UPDATE categories SET nom = :nom WHERE id = :id AND supprimer = 0');
        return $stmt->execute(['id' => $id, 'nom' => $nom]);
    }

    public function softDelete(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE categories SET supprimer = 1 WHERE id = :id AND supprimer = 0');
        return $stmt->execute(['id' => $id]);
    }
}
