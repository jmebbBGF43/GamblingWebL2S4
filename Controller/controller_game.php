<?php
require_once "../configuration/config.php";

require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "Model/Class/GameManager.php";

use Model\Entity\GameManager;

$gameSlug = $_GET['game'] ?? '';
if (empty($gameSlug)) {
    header("Location: " . BASE_URL . "index.php");
    exit();
}
$gameManager = new GameManager();
$gameData = $gameManager->getGameDataSlug($gameSlug);
if (!$gameData || !$gameData['is_active']) {
    header("Location: " . BASE_URL . "index.php");
    exit();
}
ob_start();
include ROOT_DIR . "view/pages/game/" . $gameSlug . ".php";
$content = ob_get_clean();
include ROOT_DIR . "view/layout.php";