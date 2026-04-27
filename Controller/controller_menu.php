<?php
require_once "../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "Model/Class/UserDB.php";

use Model\Entity\UserDB;

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "connexion");
    exit();
}

$user_pageID = $_GET['user_pageID'] ?? '';
$allowed_user_page = ["profile", "payment", "parameter"];

if (in_array($user_pageID, $allowed_user_page)) {

    $userDB = new UserDB();
    $userData = $userDB->getUserById($_SESSION['user_id']);

    if (!$userData) {
        session_destroy();
        header("Location: " . BASE_URL . "home");
        exit();
    }

    if ($user_pageID === 'profile') {
        $firstLetter = strtoupper(substr($userData['username'], 0, 1));
        $dateInscription = date('d / m / Y', strtotime($userData['created_at']));
        $creditsFormate = number_format($userData['credits'], 2, '.', ' ');

        $totalProfit = $userDB->getTotalProfit($_SESSION['user_id']);

        $profitSigne = $totalProfit > 0 ? '+ ' : ($totalProfit < 0 ? '- ' : '');
        $profitFormate = $profitSigne . number_format(abs($totalProfit), 2, '.', ' ');
        $profitColor = $totalProfit > 0 ? 'text-green-500' : ($totalProfit < 0 ? 'text-red-500' : 'text-[#9d9d9d]');

        $restrictions = [];
        if ($userData['is_banned']) $restrictions[] = "Banni";
        if (!$userData['can_play']) $restrictions[] = "Jeu bloqué";
        if (!$userData['can_transact']) $restrictions[] = "Transactions bloquées";

        $restrictionText = empty($restrictions) ? "Aucune restriction" : implode(", ", $restrictions);
        $restrictionColor = empty($restrictions) ? "text-green-400" : "text-red-500";
    }
    ob_start();
    include ROOT_DIR . "view/pages/user/" . $user_pageID . ".php";
    $content = ob_get_clean();

    include ROOT_DIR . "view/layout_header.php";

} else {
    header("Location: " . BASE_URL . "home");
    exit();
}