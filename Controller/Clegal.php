<?php
require_once "../configuration/config.php";

$path_info = $_SERVER['PATH_INFO'] ?? '/';
$legalID= trim($path_info, '/');
$allowed_legal = [
    "condition", "confidentialite", "support"
];

if (in_array($legalID, $allowed_legal)) {
    ob_start();
    include ROOT_DIR . "view/pages/legal/" . $legalID . ".php";
    $content = ob_get_clean();
    include ROOT_DIR . "view/layout_header.php";

} else {
    header("Location: ../index.php");
    exit();
}