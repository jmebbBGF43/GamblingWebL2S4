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

    public function insertUser(User $user){
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

    public function verifyUser($user): bool
    {
        $sql = "SELECT * FROM users WHERE username = ?;";
        $stat = ($this->db)->prepare($sql);

        $stat->execute([$user->getUsername()]);

        $result = $stat->fetch();
        return $result && password_verify($user->getPassword(), $result['password_hash']);
    }
}

