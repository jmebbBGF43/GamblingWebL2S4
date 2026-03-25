<?php

namespace Model\ConnexionDB;
use Model\ConfigurationDB;
use \PDO;
use \PDOException;
class ConnexionDB {
    private static PDO $pdo;
    private function __construct() {
        try {
            $config = new ConfigurationDB();
            $this->pdo = new PDO($config->getDNS(), $config->getUsername(), $config->getPassword(), array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            die("Erreur de connexion à la DB : " . $e->getMessage());
        }
    }

    public function getPDO(): PDO
    {
        if (!self::$pdo) {
            $this->__construct();
        }
        return self::$pdo;
    }
}
