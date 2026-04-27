<?php

namespace Model;
require_once __DIR__ . '/ConfigurationDB.php';
use Model\ConfigurationDB;
use \PDO;
use \PDOException;

/**
 * Classe ConnexionDB
 * 
 * Gère la connexion à la base de données via PDO en utilisant le pattern Singleton.
 */
class ConnexionDB {
    /**
     * @var PDO|null Instance unique de la connexion à la base de données PDO.
     */
    private static ?PDO $pdo = null;

    /**
     * Constructeur privé (Pattern Singleton).
     * Initialise la connexion à la base de données à l'aide de la configuration.
     */
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

    /**
     * Retourne l'instance unique de l'objet PDO. La crée si elle n'existe pas.
     * 
     * @return PDO L'instance active de connexion PDO.
     */
    public static function getPDO(): PDO
    {
        if (self::$pdo === null) {
            new self();
        }
        return self::$pdo;
    }
}
