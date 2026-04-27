<?php
namespace Model\Entity;
use PDO;

class FaqManager {
    private $db;

    public function __construct() {
        $this->db = \Model\ConnexionDB::getPDO();
    }

    public function getAllFaqs() {
        return $this->db->query("SELECT * FROM faq ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFaqById($id) {
        $stmt = $this->db->prepare("SELECT * FROM faq WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertFaq($question, $answer) {
        $sql = "INSERT INTO faq (question, answer, is_active) VALUES (?, ?, true);";
        $this->db->prepare($sql)->execute([$question, $answer]);
    }

    public function updateFaq($id, $question, $answer, $is_active) {
        $sql = "UPDATE faq SET question = ?, answer = ?, is_active = ? WHERE id = ?;";
        $this->db->prepare($sql)->execute([$question, $answer, $is_active ? 'true' : 'false', $id]);
    }

    public function deleteFaq($id) {
        $this->db->prepare("DELETE FROM faq WHERE id = ?")->execute([$id]);
    }

    public function toggleActive($id) {
        $sql = "UPDATE faq SET is_active = NOT is_active WHERE id = ?;";
        $this->db->prepare($sql)->execute([$id]);
    }

    public function getActiveFaqs() {
        // On rajoute "WHERE is_active = true" pour filtrer directement en base de données
        return $this->db->query("SELECT * FROM faq WHERE is_active = true ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
}