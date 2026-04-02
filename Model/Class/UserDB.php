<?php


namespace Model\Entity;
use Model\ConnexionDB;
use Model\Entity\User;
use PDO;

class UserDB{
    private $db;
    function __construct(){
        $this->db= ConnexionDB::getPDO();
    }

    public function insertUser($user){
        $sql = "INSERT INTO users (username, password_hash, credits, role, is_banned, can_play, can_transact, created_at) values(?,?,?,?,?,?,?,?);";
        $stat = $this->db->prepare($sql);
        $stat->execute([$user->username, $user->password, $user->credits, $user->role, $user->is_banned ? 'true' : 'false', $user->can_play ? 'true' : 'false', $user->can_transact ? 'true' : 'false', $user->created_at]);
    }

    public function updateUser($id, $username, $credits, $role, $is_banned, $can_play, $can_transact) {
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

    public function deleteUser($id) {
        $this->db->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        return $this->db->query("SELECT * FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
}

