<?php
require_once "../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "Model/ConfigurationDB.php";
require_once ROOT_DIR . "Model/Class/GameManager.php";
require_once ROOT_DIR . "Model/Class/Game.php";

require_once ROOT_DIR . "Model/Class/Games/PileOuFace.php";

use Model\Entity\GameManager;
use Model\Entity\Games\PileOuFace;

header('Content-Type: application/json');
$rawData = file_get_contents("php://input");
$request = json_decode($rawData, true);

$bet = floatval($request['bet'] ?? 0);
$gameSlug = $request['game'] ?? '';

if ($bet <= 0 || empty($gameSlug)) {
    echo json_encode(['status' => 'error', 'message' => 'Mise ou jeu invalide.']);
    exit();
}

try {
    $gameManager = new GameManager();
    $gameData = $gameManager->getGameDataSlug($gameSlug);

    if (!$gameData) {
        throw new \Exception("Jeu introuvable dans la base de données.");
    }

    $game = null;
    $payout = 0;
    $outcome = '';

    switch ($gameSlug) {

        case 'pileOuFace':
            $choice = $request['choice'] ?? '';
            if (!in_array($choice, ['pile', 'face', 'tranche'])) {
                throw new \Exception("Choix invalide pour Pile ou Face.");
            }
            $game = new PileOuFace($gameData['id'], $gameData['name'], $gameData['probabilities'], $gameData['is_active'], $gameData['slug']);
            if (!$game->isBetValid($bet)) {
                throw new \Exception("Mise invalide (Min: {$game->getMinBet()} / Max: {$game->getMaxBet()})");
            }
            $payout = $game->run($bet, $choice);
            $outcome = $game->getOutcome();
            break;


        default:
            throw new \Exception("Ce jeu n'est pas encore configuré ou n'existe pas");
    }

    // mettre le debit/credit de USER ici plus tadr

    if ($payout > 0) {
        echo json_encode(['status' => 'win', 'payout' => $payout, 'outcome' => $outcome, 'message' => 'C\'est gagné !']);
    } else {
        echo json_encode(['status' => 'loss', 'payout' => $bet, 'outcome' => $outcome, 'message' => 'Perdu, dommage.']);
    }

} catch (\Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}