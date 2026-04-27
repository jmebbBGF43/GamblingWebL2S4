<?php
require_once "../configuration/config.php";

$legalID= $_GET["legalID"] ?? '';
$allowed_legal = [
    "condition", "confidentialite", "support"
];

if (in_array($legalID, $allowed_legal)) {
    ob_start();
    include ROOT_DIR . "view/pages/legal/" . $legalID . ".php";
    $content = ob_get_clean();
    include ROOT_DIR . "view/layout_header.php";

} else {
    header("Location: " . BASE_URL . "home");
    exit();
}