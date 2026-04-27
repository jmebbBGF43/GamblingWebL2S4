<?php
namespace Model\Entity;
use PDO;

/**
 * Classe FaqManager
 * 
 * Manager dédié à l'interface d'administration pour la Foire Aux Questions (FAQ).
 * Fournit les opérations CRUD de base.
 */
class FaqManager {
    /**
     * @var PDO Instance de connexion à la base de données
     */
    private $db;

    /**
     * Constructeur de FaqManager.
     */
    public function __construct() {
        $this->db = \Model\ConnexionDB::getPDO();
    }

    /**
     * Récupère l'ensemble des questions de la FAQ, qu'elles soient actives ou inactives.
     * 
     * @return array La liste des FAQ (les plus récentes en premier)
     */
    public function getAllFaqs() {
        return $this->db->query("SELECT * FROM faq ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une entrée de la FAQ spécifiquement par son identifiant.
     * 
     * @param int $id L'identifiant de la question
     * @return array|false L'enregistrement de la FAQ ou false s'il n'existe pas
     */
    public function getFaqById($id) {
        $stmt = $this->db->prepare("SELECT * FROM faq WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute une nouvelle question/réponse à la FAQ. Elle est active par défaut.
     * 
     * @param string $question L'intitulé de la question
     * @param string $answer La réponse associée
     * @return void
     */
    public function insertFaq($question, $answer) {
        $sql = "INSERT INTO faq (question, answer, is_active) VALUES (?, ?, true);";
        $this->db->prepare($sql)->execute([$question, $answer]);
    }

    /**
     * Modifie une entrée existante de la FAQ.
     * 
     * @param int $id L'identifiant de la question
     * @param string $question La question modifiée
     * @param string $answer La réponse modifiée
     * @param bool $is_active Le statut d'affichage (True = visible par les joueurs)
     * @return void
     */
    public function updateFaq($id, $question, $answer, $is_active) {
        $sql = "UPDATE faq SET question = ?, answer = ?, is_active = ? WHERE id = ?;";
        $this->db->prepare($sql)->execute([$question, $answer, $is_active ? 'true' : 'false', $id]);
    }

    /**
     * Supprime définitivement une entrée de la FAQ.
     * 
     * @param int $id L'identifiant de la question à supprimer
     * @return void
     */
    public function deleteFaq($id) {
        $this->db->prepare("DELETE FROM faq WHERE id = ?")->execute([$id]);
    }

    /**
     * Alterne le statut de visibilité d'une question (actif <=> inactif).
     * 
     * @param int $id L'identifiant de la question
     * @return void
     */
    public function toggleActive($id) {
        $sql = "UPDATE faq SET is_active = NOT is_active WHERE id = ?;";
        $this->db->prepare($sql)->execute([$id]);
    }

    /**
     * Récupère uniquement les entrées actives de la FAQ destinées au front-office.
     * 
     * @return array Liste des questions actives
     */
    public function getActiveFaqs() {
        return $this->db->query("SELECT * FROM faq WHERE is_active = true ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
}