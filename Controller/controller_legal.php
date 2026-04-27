<?php
require_once "../configuration/config.php";
// Ajoute ces deux lignes pour pouvoir lire la base de données
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "admin/Model/Class/FaqManager.php";

$legalID = $_GET["legalID"] ?? '';
$allowed_legal = [
    "condition", "confidentialite", "support"
];

if (in_array($legalID, $allowed_legal)) {

    // --- C'EST ICI QU'ON CRÉE LA VARIABLE FAQ ---
    // On ne le fait QUE si l'utilisateur demande la page support
    if ($legalID === 'support') {
        $faqManager = new \Model\Entity\FaqManager();
        $faqs = $faqManager->getActiveFaqs(); // (Vérifie juste si c'est getAllFaq ou getAllFaqs dans ton FaqManager.php)
    }
    // --------------------------------------------

    ob_start();
    include ROOT_DIR . "view/pages/legal/" . $legalID . ".php";
    $content = ob_get_clean();

    include ROOT_DIR . "view/layout_header.php";

} else {
    header("Location: " . BASE_URL . "home");
    exit();
}