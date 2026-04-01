<?php

namespace Model\Entity;
class GameManager
{
    protected \PDO $db;
    public function __construct()
    {
        $this->db = \Model\ConnexionDB::getPDO();
    }

    public function getIDs(): array
    {
        $sql = "SELECT id FROM games;";
        return $this->db->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getSlugs(): array
    {
        $sql = "SELECT slug FROM games;";
        return $this->db->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getSpecificID(string $slug)
    {
        $sql = "SELECT id FROM games WHERE slug = :slug;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetchColumn();
    }

    public function getSpecificSlug(int $id)
    {
        $sql = "SELECT slug FROM games WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }

    public function getNameFromID(int $id)
    {
        $sql = "SELECT name FROM games WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }

    public function getNameFromSlug(string $slug)
    {
        $sql = "SELECT name FROM games WHERE slug = :slug;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetchColumn();
    }

    public function getActive(int $id)
    {
        $sql = "SELECT is_active FROM games WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }

    public function getProbs(int $id): array
    {
        $sql = "SELECT probabilities FROM games WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $probs = $stmt->fetchColumn();
        return $probs ? json_decode($probs, true) : [];
    }

    public function setProbs(int $id, array $probs): void
    {
        $sql = "UPDATE games SET probabilities = :probs WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['probs' => json_encode($probs), 'id' => $id]);
    }

    public function setActive(int $id, bool $active): void
    {
        $sql = "UPDATE games SET is_active = :active WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['active' => $active, 'id' => $id]);
    }

    public function getGameDataSlug(string $slug): ?array
    {
        $sql = "SELECT * FROM games WHERE slug = :slug;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $data = $stmt->fetch();

        if ($data) {
            $data['probabilities'] = json_decode($data['probabilities'], true) ?? [];
        }
        return $data ?: null;
    }
    public function getGameDataId(int $id): ?array
    {
        $sql = "SELECT * FROM games WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();

        if ($data) {
            $data['probabilities'] = json_decode($data['probabilities'], true) ?? [];
        }
        return $data ?: null;
    }
}
