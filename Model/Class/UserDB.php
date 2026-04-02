<?php


namespace Model\Entity;
use Model\ConnexionDB;
use Model\Entity\User;
use PDO;
require_once __DIR__ . '/UserDBInterface.php';

class UserDB implements UserDBInterface{
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

    public function verifyUser($user): bool
    {
        $sql = "SELECT * FROM users WHERE username = ?;";
        $stat = ($this->db)->prepare($sql);
        $stat->execute([$user->getUsername()]);
        $result = $stat->fetch();
        return $result && password_verify($user->getPassword(), $result['password_hash']);
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
}

