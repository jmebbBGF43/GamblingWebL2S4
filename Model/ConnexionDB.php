<?php

namespace Model;
use Model\ConfigurationDB;
use \PDO;
use \PDOException;
class ConnexionDB {
    private static ?PDO $pdo = null;

    private function __construct() {
        try {
            $config = new ConfigurationDB();
            self::$pdo = new PDO(
                $config->getDNS(),
                $config->getUsername(),
                $config->getPassword(),
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion à la DB : " . $e->getMessage());
        }
    }

    public static function getPDO(): PDO
    {
        if (self::$pdo === null) {
            new self();
        }
        return self::$pdo;
    }
}
