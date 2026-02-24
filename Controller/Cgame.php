<?php
require_once "../configuration/config.php";

$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$gameId = trim($path_info, '/');
$allowed_games = [
    "pileOuFace", "caseOpening", "slotMachine", "mine",
    "blackJack", "upgrade", "crash", "plinko",
    "pocker", "roulette", "pariSportif", "craps"
];

if (in_array($gameId, $allowed_games)) {
    ob_start();
    include ROOT_DIR . "view/pages/game/" . $gameId . ".php";
    $content = ob_get_clean();
    include ROOT_DIR . "view/layout.php";

} else {
    header("Location: ../index.php");
    exit();
}