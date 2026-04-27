<?php


namespace Model\Entity;
use Model\ConnexionDB;
use Model\Entity\User;
use PDO;
//require_once __DIR__ . '/UserDBInterface.php';

class UserDB{
    private $db;
    function __construct(){
        $this->db= ConnexionDB::getPDO();
    }

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

    public function deleteUser($id): void
    {
        $this->db->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers(): array
    {
        return $this->db->query("SELECT * FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateUserCredits($id, $newCredits) {
        $sql = "UPDATE users SET credits = ? WHERE id = ?;";
        $this->db->prepare($sql)->execute([$newCredits, $id]);
    }

    public function logBet($userId, $gameId, $betAmount, $payout) {
        $status = $payout > 0 ? 'win' : 'loss';
        $sql = "INSERT INTO bets (user_id, game_id, bet_amount, payout, status) VALUES (?, ?, ?, ?, ?);";
        $this->db->prepare($sql)->execute([$userId, $gameId, $betAmount, $payout, $status]);
    }

    public function getTotalProfit($userId) {
        $sql = "SELECT SUM(payout - bet_amount) as total_profit FROM bets WHERE user_id = ?;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        return $result['total_profit'] ?? 0; // Retourne 0 si le mec n'a jamais joué
    }
    public function updatePassword($id, $newPasswordHash) {
        $sql = "UPDATE users SET password_hash = ? WHERE id = ?;";
        $this->db->prepare($sql)->execute([$newPasswordHash, $id]);
    }

    // Fonction pour supprimer un compte définitivement
    public function deleteUserAccount($userId) {
        // 1. (Optionnel) Si tes autres tables (contact_messages, etc.) n'ont pas l'option "ON DELETE CASCADE" en SQL,
        // tu dois supprimer les données liées avant l'utilisateur pour éviter une erreur de clé étrangère.
        $this->db->prepare("DELETE FROM contact_messages WHERE user_id = ?")->execute([$userId]);

        // 2. Suppression de l'utilisateur
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$userId]);
    }
}

