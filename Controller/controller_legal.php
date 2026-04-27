<?php
require_once "../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "admin/Model/Class/FaqManager.php";

$legalID = $_GET["legalID"] ?? '';
$allowed_legal = [
    "condition", "confidentialite", "support"
];

if (in_array($legalID, $allowed_legal)) {
    if ($legalID === 'support') {
        $faqManager = new \Model\Entity\FaqManager();
        $faqs = $faqManager->getActiveFaqs();
    }
    ob_start();
    include ROOT_DIR . "view/pages/legal/" . $legalID . ".php";
    $content = ob_get_clean();

    include ROOT_DIR . "view/layout_header.php";

} else {
    header("Location: " . BASE_URL . "home");
    exit();
}