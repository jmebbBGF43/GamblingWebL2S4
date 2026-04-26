<?php
namespace Model\Entity;
use PDO;

class MailManager {
    private $db;

    public function __construct() {
        $this->db = \Model\ConnexionDB::getPDO();
    }

    public function getAllMails() {
        // Le JOIN permet de récupérer le 'username' de celui qui envoie et celui qui reçoit
        $sql = "SELECT m.*, u1.username AS sender_name, u2.username AS receiver_name 
                FROM mail m 
                LEFT JOIN users u1 ON m.sender_id = u1.id 
                LEFT JOIN users u2 ON m.receiver_id = u2.id 
                ORDER BY m.id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertMail($sender_id, $receiver_id, $subject, $message) {
        $sql = "INSERT INTO mail (sender_id, receiver_id, subject, message) VALUES (?, ?, ?, ?);";
        $this->db->prepare($sql)->execute([$sender_id, $receiver_id, $subject, $message]);
    }

    public function deleteMail($id) {
        $this->db->prepare("DELETE FROM mail WHERE id = ?")->execute([$id]);
    }
}