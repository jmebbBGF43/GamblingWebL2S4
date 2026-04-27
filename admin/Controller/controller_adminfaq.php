<?php


require_once "controller_adminlogin.php";
require_once "../../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "admin/Model/Class/FaqManager.php";

$faqManager = new \Model\Entity\FaqManager();
$action = $_GET['action_faq'] ?? '';

// Traitement des actions
// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité : Jeton CSRF invalide.");
    }

    if ($action === 'store') {
        $faqManager->insertFaq($_POST['question'], $_POST['answer']);
        header("Location: controller_adminfaq.php");
        exit();
    } elseif ($action === 'update') {
        $faqManager->updateFaq($_POST['id'], $_POST['question'], $_POST['answer'], isset($_POST['is_active']));
        header("Location: controller_adminfaq.php");
        exit();
    }
} elseif ($action === 'delete' && isset($_GET['id'])) {
    $faqManager->deleteFaq($_GET['id']);
    header("Location: controller_adminfaq.php");
    exit();
} elseif ($action === 'toggle' && isset($_GET['id'])) {
    $faqManager->toggleActive($_GET['id']);
    header("Location: controller_adminfaq.php");
    exit();
}

ob_start();
if ($action === 'edit' && isset($_GET['id'])) {
    $f = $faqManager->getFaqById($_GET['id']);
    include '../view/pages/form_faq.php'; // On peut créer un petit form à part ou l'intégrer
} else {
    $faqs = $faqManager->getAllFaqs();
    include '../view/pages/adminfaq.php';
}
$content = ob_get_clean();
include '../view/layout/layout.php';