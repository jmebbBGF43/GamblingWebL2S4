<?php
require_once "../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "Model/ConfigurationDB.php";
require_once ROOT_DIR . "Model/Class/GameManager.php";
require_once ROOT_DIR . "Model/Class/GameInterface.php";
require_once ROOT_DIR . "Model/Class/Game.php";
require_once ROOT_DIR . "Model/Class/Games/PileOuFace.php";
require_once ROOT_DIR . "Model/Class/Games/CaseOpening.php";
require_once ROOT_DIR . "Model/Class/UserDB.php";

use Model\Entity\GameManager;
use Model\Entity\Games\PileOuFace;
use Model\Entity\Games\CaseOpening;
use Model\Entity\UserDB;

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Tu dois être connecté pour jouer.']);
    exit();
}

$rawData = file_get_contents("php://input");
$request = json_decode($rawData, true);
if (!isset($request['csrf_token']) || $request['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['status' => 'error', 'message' => 'Erreur de sécurité (CSRF). Veuillez rafraîchir la page.']);
    exit();
}
$bet = floatval($request['bet'] ?? 0);
$gameSlug = $request['game'] ?? '';

if ($bet <= 0 || empty($gameSlug)) {
    echo json_encode(['status' => 'error', 'message' => 'Mise ou jeu invalide.']);
    exit();
}

try {
    $userDB = new UserDB();
    $userData = $userDB->getUserById($_SESSION['user_id']);

    if ($userData['credits'] < $bet) {
        throw new \Exception("Fonds insuffisants. Solde actuel: {$userData['credits']} €");
    }

    $gameManager = new GameManager();
    $gameData = $gameManager->getGameDataSlug($gameSlug);

    if (!$gameData) throw new \Exception("Jeu introuvable dans la base de données.");

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
        case 'caseOpening':
            $choice = $request['choice'] ?? '';
            if (empty($choice)) {
                throw new \Exception("Veuillez sélectionner une caisse.");
            }
            $configArray = is_string($gameData['probabilities']) ? json_decode($gameData['probabilities'], true) : $gameData['probabilities'];
            $game = new CaseOpening($gameData['id'], $gameData['name'], $configArray, $gameData['is_active'], $gameData['slug'], 1, 10000);
            $payout = $game->run($bet, $choice);
            $outcome = $game->getWonRarity();
            break;
        default:
            throw new \Exception("Ce jeu n'est pas encore configuré.");
    }

    $newCredits = $userData['credits'] - $bet + $payout;
    $userDB->updateUserCredits($_SESSION['user_id'], $newCredits);
    $userDB->logBet($_SESSION['user_id'], $gameData['id'], $bet, $payout);


    if ($payout > 0) {
        echo json_encode(['status' => 'win', 'payout' => $payout, 'new_balance' => $newCredits, 'outcome' => $outcome, 'message' => 'C\'est gagné !']);
    } else {
        echo json_encode(['status' => 'loss', 'payout' => $bet, 'new_balance' => $newCredits, 'outcome' => $outcome, 'message' => 'Perdu, dommage.']);
    }

} catch (\Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}