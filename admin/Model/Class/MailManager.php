<?php
namespace Model\Entity;
use PDO;

class MailManager {
    private $db;

    public function __construct() {
        $this->db = \Model\ConnexionDB::getPDO();
    }

    // Récupère tous les messages
    public function getAllMessages() {
        $sql = "SELECT cm.*, u.username 
                FROM contact_messages cm 
                LEFT JOIN users u ON cm.user_id = u.id 
                ORDER BY cm.created_at DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère un message spécifique pour l'envoi de mail
    public function getMessageById($id) {
        $stmt = $this->db->prepare("SELECT * FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mise à jour du statut (Uniquement 'read' ou 'unread')
    public function updateStatus($id, $status) {
        $sql = "UPDATE contact_messages SET status = ? WHERE id = ?;";
        $this->db->prepare($sql)->execute([$status, $id]);
    }

    // Sauvegarde la réponse et passe le message en "Lu"
    public function saveReply($id, $reply_text) {
        $sql = "UPDATE contact_messages SET admin_reply = ?, status = 'read' WHERE id = ?;";
        $this->db->prepare($sql)->execute([$reply_text, $id]);
    }

    public function deleteMessage($id) {
        $this->db->prepare("DELETE FROM contact_messages WHERE id = ?")->execute([$id]);
    }
}