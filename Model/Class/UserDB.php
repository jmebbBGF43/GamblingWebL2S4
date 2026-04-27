<?php


namespace Model\Entity;
use Model\ConnexionDB;
use Model\Entity\User;
use PDO;
//require_once __DIR__ . '/UserDBInterface.php';

/**
 * Classe UserDB
 * 
 * Manager gérant les requêtes PDO pour l'entité User.
 * S'occupe du CRUD et des opérations liées aux joueurs (transactions, droits).
 */
class UserDB{
    /**
     * @var PDO L'instance de connexion à la base de données
     */
    private $db;

    /**
     * Constructeur du manager UserDB.
     */
    function __construct(){
        $this->db= ConnexionDB::getPDO();
    }

    /**
     * Insère un nouvel utilisateur dans la base de données.
     * 
     * @param User $user L'entité utilisateur à insérer
     * @return void
     * @throws \Exception Si le nom d'utilisateur est déjà présent dans la base
     */
    public function insertUser(User $user): void
    {
        $sql = "SELECT * FROM users WHERE username = ?;";
        $stat = $this->db->prepare($sql);
        $stat->execute([$user->getUsername()]);
        $result = $stat->fetch();
        if($result){
            throw new \Exception("<p class='text-red-500 text-2xl font-bold mb-2 text-center mt-4 mb-4'>Ce nom d'utilisateur est déjà utilisé</p>");
        }
        $sql = "INSERT INTO users (username, password_hash, credits, role, is_banned, can_play, can_transact, created_at) values(?,?,?,?,?,?,?,?);";
        $stat = $this->db->prepare($sql);
        $stat->execute([$user->getUsername(), $user->getPassword(), $user->getCredits(), $user->getRole(), $user->isBanned() ? 'true' : 'false', $user->canPlay() ? 'true' : 'false', $user->canTransact() ? 'true' : 'false', $user->getCreatedAt()]);
    }

    /**
     * Met à jour les informations globales d'un utilisateur.
     * 
     * @param int $id L'identifiant de l'utilisateur
     * @param string $username Le nom d'utilisateur
     * @param float $credits Les crédits actuels du joueur
     * @param string $role Le rôle du joueur (ex: user, admin)
     * @param bool $is_banned Le statut de bannissement
     * @param bool $can_play L'autorisation de jouer aux jeux
     * @param bool $can_transact L'autorisation d'effectuer des transactions
     * @return void
     */
    public function updateUser($id, $username, $credits, $role, $is_banned, $can_play, $can_transact): void
    {
        $sql = "UPDATE users SET username=?, credits=?, role=?, is_banned=?, can_play=?, can_transact=? WHERE id=?;";
        $this->db->prepare($sql)->execute([
            $username,
            $credits,
            $role,
            $is_banned ? 'true' : 'false',
            $can_play ? 'true' : 'false',
            $can_transact ? 'true' : 'false',
            $id
        ]);
    }

    /**
     * Vérifie l'existence et la validité du mot de passe d'un utilisateur.
     * 
     * @param User $user L'entité utilisateur contenant les credentials à vérifier
     * @return array|false Retourne les données de l'utilisateur en cas de succès, sinon false
     */
    public function verifyUser($user)
    {
        $sql = "SELECT * FROM users WHERE username = ?;";
        $stat = $this->db->prepare($sql);
        $stat->execute([$user->getUsername()]);
        $result = $stat->fetch();
        if ($result && password_verify($user->getPassword(), $result['password_hash'])) {
            return $result;
        }
        return false;
    }

    /**
     * Supprime un utilisateur de la base de données via son ID.
     * 
     * @param int $id L'identifiant de l'utilisateur
     * @return void
     */
    public function deleteUser($id): void
    {
        $this->db->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
    }

    /**
     * Récupère les données d'un utilisateur spécifique via son identifiant.
     * 
     * @param int $id L'identifiant de l'utilisateur
     * @return array|false Un tableau contenant les informations du joueur, ou false s'il n'existe pas
     */
    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère la totalité des utilisateurs enregistrés, du plus récent au plus ancien.
     * 
     * @return array Liste de tous les utilisateurs
     */
    public function getAllUsers(): array
    {
        return $this->db->query("SELECT * FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour uniquement le solde de crédits d'un utilisateur.
     * 
     * @param int $id L'identifiant de l'utilisateur
     * @param float $newCredits Le nouveau solde de crédits
     * @return void
     */
    public function updateUserCredits($id, $newCredits) {
        $sql = "UPDATE users SET credits = ? WHERE id = ?;";
        $this->db->prepare($sql)->execute([$newCredits, $id]);
    }

    /**
     * Enregistre l'historique d'un pari effectué sur un jeu.
     * 
     * @param int $userId L'identifiant du joueur
     * @param int $gameId L'identifiant du jeu
     * @param float $betAmount Le montant misé par le joueur
     * @param float $payout Le montant gagné en retour (0 si perte)
     * @return void
     */
    public function logBet($userId, $gameId, $betAmount, $payout) {
        $status = $payout > 0 ? 'win' : 'loss';
        $sql = "INSERT INTO bets (user_id, game_id, bet_amount, payout, status) VALUES (?, ?, ?, ?, ?);";
        $this->db->prepare($sql)->execute([$userId, $gameId, $betAmount, $payout, $status]);
    }

    /**
     * Calcule et retourne le bénéfice net total d'un joueur (Gains - Mises).
     * 
     * @param int $userId L'identifiant du joueur
     * @return float Le montant du bénéfice total généré (0 par défaut)
     */
    public function getTotalProfit($userId) {
        $sql = "SELECT SUM(payout - bet_amount) as total_profit FROM bets WHERE user_id = ?;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        return $result['total_profit'] ?? 0; // Retourne 0 si le mec n'a jamais joué
    }

    /**
     * Met à jour le mot de passe hashé d'un utilisateur.
     * 
     * @param int $id L'identifiant de l'utilisateur
     * @param string $newPasswordHash Le nouveau hash du mot de passe
     * @return void
     */
    public function updatePassword($id, $newPasswordHash) {
        $sql = "UPDATE users SET password_hash = ? WHERE id = ?;";
        $this->db->prepare($sql)->execute([$newPasswordHash, $id]);
    }

    /**
     * Supprime définitivement le compte d'un utilisateur et nettoie les données liées (ex: messages).
     * 
     * @param int $userId L'identifiant de l'utilisateur à supprimer
     * @return bool True si la suppression est un succès, False sinon
     */
    public function deleteUserAccount($userId) {
        $this->db->prepare("DELETE FROM contact_messages WHERE user_id = ?")->execute([$userId]);
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$userId]);
    }
}
