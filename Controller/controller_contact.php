<?php
require_once "../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "Model/Class/ContactDB.php";

use Model\Entity\ContactDB;

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "Controller/controller_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $replyEmail = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (!empty($replyEmail) && !empty($subject) && !empty($message)) {
        try {
            $contactDB = new ContactDB();
            $contactDB->saveMessage($_SESSION['user_id'], $replyEmail, $subject, $message);
            $to = "gambling.io.ams@gmail.com";
            $mailSubject = "[Gambling.io Support] " . $subject;

            $mailBody = "Nouveau message du support :\n\n";
            $mailBody .= "Utilisateur : " . $_SESSION['username'] . " (ID: " . $_SESSION['user_id'] . ")\n";
            $mailBody .= "Email de réponse : " . $replyEmail . "\n\n";
            $mailBody .= "Message :\n" . $message;

            $headers = "From: noreply@gambling.io\r\n";
            $headers .= "Reply-To: " . $replyEmail . "\r\n";

            mail($to, $mailSubject, $mailBody, $headers);

            $_SESSION['contact_success'] = "Ton message a bien été envoyé au support !";
        } catch (\Exception $e) {
            $_SESSION['contact_error'] = "Erreur lors de l'enregistrement du message.";
        }
    } else {
        $_SESSION['contact_error'] = "Tous les champs sont obligatoires.";
    }
}

$retour = $_SERVER['HTTP_REFERER'] ?? BASE_URL . 'index.php';
header("Location: " . $retour);
exit();
