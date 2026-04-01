<?php


namespace Model\Entity;
use Model\ConnexionDB;
use PDO;

class UserDB{
    private $db;

    function __construct(){
        $this->db= ConnexionDB::getPDO();
    }

    public function insertUser($user){
        $sql = "INSERT INTO users (username, password_hash, credits, role, is_banned, can_play, can_transact, created_at) values(?,?,?,?,?,?,?,?);";
        $stat = ($this->db)->prepare($sql);
        
        $stat->execute([$user->username, $user->password, $user->credits, $user->role, $user->is_banned ? 'true' : 'false', $user->can_play ? 'true' : 'false', $user->can_transact ? 'true' : 'false', $user->created_at]);
    }

    public function verifyUser($user) {
        $sql = "SELECT * FROM users WHERE username = ? AND password_hash = ?;";
        $stat = ($this->db)->prepare($sql);

        $stat->execute([$user->username, $user->password]);

        $result = $stat->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}

