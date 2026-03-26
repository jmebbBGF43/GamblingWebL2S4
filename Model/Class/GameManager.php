<?php

namespace Model\Entity;

use Model\ConfigurationDB;

class GameManager
{
    protected \PDO $db;
    public function __construct(ConfigurationDB $db)
    {
        $this->db = \Model\ConnexionDB::getPDO();
    }

    public function getIDs(): array
    {
        $sql = "SELECT id FROM games;";
        return $this->db->query($sql)->fetchAll();
    }
    public function getSlugs(): array
    {
        $sql = "SELECT slug FROM games;";
        return $this->db->query($sql)->fetchAll();
    }

    public function getSpecificID(string $slug): array
    {
        $sql = "SELECT id FROM games WHERE slug = '$slug';";
        return $this->db->query($sql)->fetchAll();
    }

    public function getSpecificSlug(int $id): array
    {
        $sql = "SELECT id FROM games WHERE slug = '$id';";
        return $this->db->query($sql)->fetchAll();
    }
    public function getNameFromID(int $int): array
    {
        $sql = "SELECT name FROM games WHERE id = '$int';";
        return $this->db->query($sql)->fetchAll();
    }
    public function getNameFromSlug(string $slug): array
    {
        $sql = "SELECT name FROM games WHERE slug = '$slug';";
        return $this->db->query($sql)->fetchAll();
    }
    public function getActive(int $id): array
    {
        $sql = "SELECT is_active FROM games WHERE id = '$id';";
        return $this->db->query($sql)->fetchAll();
    }
    public function getProbs(int $id): array
    {
        $sql = "SELECT probabilities FROM games WHERE id = '$id';";
        return $this->db->query($sql)->fetchAll();
    }
}