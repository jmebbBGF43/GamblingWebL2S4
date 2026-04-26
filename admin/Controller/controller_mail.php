<?php
require_once "controller_adminlogin.php";
require_once __DIR__ . "/../../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "admin/Model/Class/MailManager.php";
require_once ROOT_DIR . "Model/Class/UserDB.php";

$mailManager = new \Model\Entity\MailManager();
$userDB = new \Model\Entity\UserDB();

$action = $_GET['action_mail'] ?? '';

// 1. Traitement de l'envoi d'un message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'store') {
    // L'expéditeur est l'admin actuellement connecté (grâce à la session)
    $sender_id = $_SESSION['id'];
    $receiver_id = $_POST['receiver_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mailManager->insertMail($sender_id, $receiver_id, $subject, $message);

    header("Location: /~uapv2500805/admin/Controller/controller_mail.php");
    exit();
}
// 2. Traitement de la suppression
elseif ($action === 'delete' && isset($_GET['id'])) {
    $mailManager->deleteMail($_GET['id']);
    header("Location: /~uapv2500805/admin/Controller/controller_mail.php");
    exit();
}

// 3. Affichage de la page
ob_start();
$mails = $mailManager->getAllMails();
$users = $userDB->getAllUsers(); // On récupère les utilisateurs pour le formulaire
include '../view/pages/adminmail.php';
$content = ob_get_clean();
include '../view/layout/layout.php';