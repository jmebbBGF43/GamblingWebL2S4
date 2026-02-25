<?php
require_once "../configuration/config.php";

$path_info = $_SERVER['PATH_INFO'] ?? '/';
$user_pageID= trim($path_info, '/');
$allowed_user_page = [
    "profile", "payment", "parameter"
];

if (in_array($user_pageID, $allowed_user_page)) {
    ob_start();
    include ROOT_DIR . "view/pages/user/" . $user_pageID . ".php";
    $content = ob_get_clean();
    include ROOT_DIR . "view/layout_header.php";

} else {
    header("Location:" . BASE_URL. "index.php");
    exit();
}