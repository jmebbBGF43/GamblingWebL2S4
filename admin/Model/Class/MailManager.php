<?php
namespace Model\Entity;
use PDO;

/**
 * Classe MailManager
 * 
 * Manager pour la gestion du back-office relative aux messages de contact et au support client.
 */
class MailManager {
    /**
     * @var PDO Instance de connexion à la base de données
     */
    private $db;

    /**
     * Constructeur de MailManager.
     */
    public function __construct() {
        $this->db = \Model\ConnexionDB::getPDO();
    }

    /**
     * Récupère la liste intégrale des messages envoyés via le formulaire de support.
     * Jointure appliquée pour récupérer également le pseudo de l'utilisateur concerné.
     * 
     * @return array L'historique complet des messages (les plus récents en premier)
     */
    public function getAllMessages() {
        $sql = "SELECT cm.*, u.username 
                FROM contact_messages cm 
                LEFT JOIN users u ON cm.user_id = u.id 
                ORDER BY cm.created_at DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les données d'un message spécifique ciblé par son identifiant.
     * 
     * @param int $id L'identifiant du message
     * @return array|false Le contenu du message ou false s'il n'existe pas
     */
    public function getMessageById($id) {
        $stmt = $this->db->prepare("SELECT * FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Modifie le statut de lecture ou de traitement d'un message.
     * 
     * @param int $id L'identifiant du message
     * @param string $status Le nouveau statut ciblé (ex: 'read' ou 'unread')
     * @return void
     */
    public function updateStatus($id, $status) {
        $sql = "UPDATE contact_messages SET status = ? WHERE id = ?;";
        $this->db->prepare($sql)->execute([$status, $id]);
    }

    /**
     * Enregistre la réponse de l'administrateur et passe automatiquement le ticket en statut "read".
     * 
     * @param int $id L'identifiant du message initial
     * @param string $reply_text Le contenu de la réponse admin
     * @return void
     */
    public function saveReply($id, $reply_text) {
        $sql = "UPDATE contact_messages SET admin_reply = ?, status = 'read' WHERE id = ?;";
        $this->db->prepare($sql)->execute([$reply_text, $id]);
    }

    /**
     * Supprime définitivement un message de la base de données.
     * 
     * @param int $id L'identifiant du message
     * @return void
     */
    public function deleteMessage($id) {
        $this->db->prepare("DELETE FROM contact_messages WHERE id = ?")->execute([$id]);
    }
}