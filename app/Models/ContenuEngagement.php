<?php

class ContenuEngagement extends Model
{
    private array $knownTables = [];

    public function countsForContent(int $contenuId): array
    {
        return [
            'commentaires' => $this->countActive('commentaires', $contenuId),
            'likes' => $this->countActive('likes', $contenuId),
            'partages' => $this->countActive('partages', $contenuId),
            'favoris' => $this->countActive('favoris', $contenuId),
        ];
    }

    public function commentsForContent(int $contenuId): array
    {
        if (!$this->tableExists('commentaires')) {
            return [];
        }

        $stmt = $this->db->prepare('SELECT * FROM commentaires WHERE contenu_id = :contenu_id AND supprimer = 0 ORDER BY date_creation DESC');
        $stmt->execute(['contenu_id' => $contenuId]);
        return $stmt->fetchAll();
    }

    public function addComment(int $contenuId, string $comment, ?string $ipAddress): bool
    {
        if (!$this->tableExists('commentaires')) {
            return false;
        }

        $stmt = $this->db->prepare('INSERT INTO commentaires (contenu_id, ip_address, commentaire) VALUES (:contenu_id, :ip_address, :commentaire)');
        return $stmt->execute([
            'contenu_id' => $contenuId,
            'ip_address' => $ipAddress,
            'commentaire' => $comment,
        ]);
    }

    public function toggleLike(int $contenuId, ?string $ipAddress): bool
    {
        return $this->activateSimpleTable('likes', $contenuId, $ipAddress);
    }

    public function toggleFavorite(int $contenuId, ?string $ipAddress): bool
    {
        return $this->toggleSimpleTable('favoris', $contenuId, $ipAddress);
    }

    public function addShare(int $contenuId, string $platform, ?string $ipAddress): bool
    {
        if (!$this->tableExists('partages')) {
            return false;
        }

        $stmt = $this->db->prepare('INSERT INTO partages (contenu_id, plateforme, ip_address) VALUES (:contenu_id, :plateforme, :ip_address)');
        return $stmt->execute([
            'contenu_id' => $contenuId,
            'plateforme' => $platform,
            'ip_address' => $ipAddress,
        ]);
    }

    public function softDeleteComment(int $id): bool
    {
        if (!$this->tableExists('commentaires')) {
            return false;
        }

        $stmt = $this->db->prepare('UPDATE commentaires SET supprimer = 1 WHERE id = :id AND supprimer = 0');
        return $stmt->execute(['id' => $id]);
    }

    private function countActive(string $table, int $contenuId): int
    {
        if (!$this->tableExists($table)) {
            return 0;
        }

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$table} WHERE contenu_id = :contenu_id AND supprimer = 0");
        $stmt->execute(['contenu_id' => $contenuId]);
        return (int)$stmt->fetchColumn();
    }

    private function toggleSimpleTable(string $table, int $contenuId, ?string $ipAddress): bool
    {
        if (!$this->tableExists($table)) {
            return false;
        }

        $stmt = $this->db->prepare("SELECT id FROM {$table} WHERE contenu_id = :contenu_id AND ip_address <=> :ip_address AND supprimer = 0 LIMIT 1");
        $stmt->execute(['contenu_id' => $contenuId, 'ip_address' => $ipAddress]);
        $existingId = $stmt->fetchColumn();

        if ($existingId) {
            $delete = $this->db->prepare("UPDATE {$table} SET supprimer = 1 WHERE id = :id");
            return $delete->execute(['id' => $existingId]);
        }

        $insert = $this->db->prepare("INSERT INTO {$table} (contenu_id, ip_address) VALUES (:contenu_id, :ip_address)");
        return $insert->execute(['contenu_id' => $contenuId, 'ip_address' => $ipAddress]);
    }

    private function activateSimpleTable(string $table, int $contenuId, ?string $ipAddress): bool
    {
        if (!$this->tableExists($table)) {
            return false;
        }

        $stmt = $this->db->prepare("SELECT id FROM {$table} WHERE contenu_id = :contenu_id AND ip_address <=> :ip_address ORDER BY id DESC LIMIT 1");
        $stmt->execute(['contenu_id' => $contenuId, 'ip_address' => $ipAddress]);
        $existingId = $stmt->fetchColumn();

        if ($existingId) {
            $update = $this->db->prepare("UPDATE {$table} SET supprimer = 0 WHERE id = :id");
            return $update->execute(['id' => $existingId]);
        }

        $insert = $this->db->prepare("INSERT INTO {$table} (contenu_id, ip_address) VALUES (:contenu_id, :ip_address)");
        return $insert->execute(['contenu_id' => $contenuId, 'ip_address' => $ipAddress]);
    }

    private function tableExists(string $table): bool
    {
        if (array_key_exists($table, $this->knownTables)) {
            return $this->knownTables[$table];
        }

        try {
            $stmt = $this->db->prepare(
                'SELECT COUNT(*)
                 FROM INFORMATION_SCHEMA.TABLES
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = :table_name'
            );
            $stmt->execute(['table_name' => $table]);
            $this->knownTables[$table] = ((int)$stmt->fetchColumn()) > 0;
        } catch (PDOException $e) {
            $this->knownTables[$table] = false;
        }

        return $this->knownTables[$table];
    }
}
