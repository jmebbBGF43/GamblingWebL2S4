<?php

namespace Model\Entity;

/**
 * Classe GameManager
 * 
 * Manager dédié à la gestion des requêtes relatives aux jeux du casino.
 * Permet de récupérer les configurations des jeux (slug, probabilités, activation) et les statistiques du casino.
 */
class GameManager
{
    /**
     * @var \PDO Instance de connexion à la base de données
     */
    protected \PDO $db;

    /**
     * Constructeur de GameManager.
     */
    public function __construct()
    {
        $this->db = \Model\ConnexionDB::getPDO();
    }

    /**
     * Récupère tous les identifiants des jeux disponibles.
     * 
     * @return array Liste des IDs
     */
    public function getIDs(): array
    {
        $sql = "SELECT id FROM games;";
        return $this->db->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Récupère tous les slugs uniques des jeux.
     * 
     * @return array Liste des slugs
     */
    public function getSlugs(): array
    {
        $sql = "SELECT slug FROM games;";
        return $this->db->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Récupère l'identifiant d'un jeu à partir de son slug.
     * 
     * @param string $slug Le slug (identifiant URL) du jeu
     * @return mixed L'identifiant du jeu, ou false si introuvable
     */
    public function getSpecificID(string $slug)
    {
        $sql = "SELECT id FROM games WHERE slug = :slug;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetchColumn();
    }

    /**
     * Récupère le slug d'un jeu à partir de son identifiant.
     * 
     * @param int $id L'identifiant du jeu
     * @return mixed Le slug du jeu, ou false si introuvable
     */
    public function getSpecificSlug(int $id)
    {
        $sql = "SELECT slug FROM games WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }

    /**
     * Récupère le nom formaté d'un jeu à partir de son identifiant.
     * 
     * @param int $id L'identifiant du jeu
     * @return mixed Le nom du jeu
     */
    public function getNameFromID(int $id)
    {
        $sql = "SELECT name FROM games WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }

    /**
     * Récupère le nom formaté d'un jeu à partir de son slug.
     * 
     * @param string $slug Le slug du jeu
     * @return mixed Le nom du jeu
     */
    public function getNameFromSlug(string $slug)
    {
        $sql = "SELECT name FROM games WHERE slug = :slug;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetchColumn();
    }

    /**
     * Récupère le statut d'activation d'un jeu.
     * 
     * @param int $id L'identifiant du jeu
     * @return mixed 1/0 ou true/false selon le driver
     */
    public function getActive(int $id)
    {
        $sql = "SELECT is_active FROM games WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }

    /**
     * Récupère et décode les probabilités configurées (JSON) d'un jeu.
     * 
     * @param int $id L'identifiant du jeu
     * @return array Les probabilités du jeu ou un tableau vide
     */
    public function getProbs(int $id): array
    {
        $sql = "SELECT probabilities FROM games WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $probs = $stmt->fetchColumn();
        return $probs ? json_decode($probs, true) : [];
    }

    /**
     * Met à jour les probabilités d'un jeu. Encode les données en JSON.
     * 
     * @param int $id L'identifiant du jeu
     * @param array $probs Le tableau de probabilités à sauvegarder
     * @return void
     */
    public function setProbs(int $id, array $probs): void
    {
        $sql = "UPDATE games SET probabilities = :probs WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['probs' => json_encode($probs), 'id' => $id]);
    }

    /**
     * Met à jour le statut (actif ou inactif) d'un jeu.
     * 
     * @param int $id L'identifiant du jeu
     * @param bool $active Le nouveau statut d'activation
     * @return void
     */
    public function setActive(int $id, bool $active): void
    {
        $sql = "UPDATE games SET is_active = :active WHERE id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['active' => $active, 'id' => $id]);
    }

    /**
     * Récupère toutes les données (ligne complète) associées à un jeu via son slug.
     * 
     * @param string $slug Le slug du jeu
     * @return array|null Le tableau des données ou null si introuvable
     */
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

    /**
     * Récupère toutes les données (ligne complète) associées à un jeu via son identifiant.
     * 
     * @param int $id L'identifiant du jeu
     * @return array|null Le tableau des données ou null si introuvable
     */
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

    /**
     * Récupère l'intégralité des jeux configurés en base de données.
     * 
     * @return array Liste exhaustive des jeux avec probabilités décodées
     */
    public function getAllGames(): array
    {
        $sql = "SELECT * FROM games ORDER BY id ASC;";
        $stmt = $this->db->query($sql);
        $games = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($games as &$game) {
            $game['probabilities'] = json_decode($game['probabilities'], true) ?? [];
        }
        return $games;
    }

    /**
     * Alterne le statut d'activation d'un jeu (switch ON/OFF).
     * 
     * @param int $id L'identifiant du jeu
     * @return void
     */
    public function toggleGameStatus($id) {
        $sql = "UPDATE games SET is_active = NOT is_active WHERE id = ?;";
        $this->db->prepare($sql)->execute([$id]);
    }

    /**
     * Calcule le total global des bénéfices générés par le casino sur l'ensemble des paris.
     * 
     * @return float Le bénéfice total du casino (Mises cumulées - Gains redistribués)
     */
    public function getCasinoProfits() {
        $sql = "SELECT SUM(bet_amount - payout) AS total_profit FROM bets";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total_profit'] !== null ? (float)$result['total_profit'] : 0.00;
    }
}
