<?php
require_once "../configuration/config.php";

$user_pageID= $_GET['user_pageID'] ?? '';
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