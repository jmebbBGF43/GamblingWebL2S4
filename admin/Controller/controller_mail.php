<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    require_once "controller_adminlogin.php";
    require_once __DIR__ . "/../../configuration/config.php";
    require_once ROOT_DIR . "Model/ConnexionDB.php";
    require_once ROOT_DIR . "admin/Model/Class/MailManager.php";

    $mailManager = new \Model\Entity\MailManager();
    $action = $_GET['action_mail'] ?? '';
    if ($action === 'reply' && $_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['mail_error'] = "Erreur de sécurité : Jeton CSRF invalide.";
            header("Location: " . BASE_URL . "admin/mails");
            exit();
        }
        $id = $_POST['id'];
        $reply_text = htmlspecialchars(trim($_POST['admin_reply']));
        $messageData = $mailManager->getMessageById($id);
        if (!$messageData) {
            $_SESSION['mail_error'] = "Erreur : Impossible de trouver le message d'origine.";
            header("Location: " . BASE_URL . "admin/mails");
            exit();
        }
        $mailManager->saveReply($id, $reply_text);
        $to = $messageData['reply_email']; // L'adresse dynamique !
        $subject = "Réponse à votre demande : " . $messageData['subject'];

        $body = "Bonjour,\n\nVoici la réponse de notre équipe à votre message :\n\n";
        $body .= "----------------------------------------\n";
        $body .= $reply_text . "\n";
        $body .= "----------------------------------------\n\n";
        $body .= "L'équipe Gambling.io";
        $headers = "From: noreply@gambling.io\r\n";
        if (mail($to, $subject, $body, $headers)) {
            $_SESSION['mail_success'] = "La réponse a bien été envoyée à " . htmlspecialchars($to) . " !";
        } else {
            $_SESSION['mail_error'] = "La réponse est sauvegardée, mais l'envoi de l'email a échoué (bloqué par le serveur).";
        }
        header("Location: " . BASE_URL . "admin/mails");
        exit();
    }
    elseif ($action === 'delete' && isset($_GET['id'])) {
        $mailManager->deleteMessage($_GET['id']);
        header("Location: " . BASE_URL . "admin/mails");
        exit();
    }
    elseif ($action === 'status' && isset($_GET['id']) && isset($_GET['status'])) {
        $mailManager->updateStatus($_GET['id'], $_GET['status']);
        header("Location: " . BASE_URL . "admin/mails");
        exit();
    }
    ob_start();
    $messages = $mailManager->getAllMessages();
    include '../view/pages/adminmail.php';
    $content = ob_get_clean();
    include '../view/layout/layout.php';

} catch (Throwable $e) {
    die("<div style='background:#b91c1c; color:white; padding:20px;'>Erreur : " . $e->getMessage() . "</div>");
}
?>