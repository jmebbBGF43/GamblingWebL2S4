<?php
require_once "controller_adminlogin.php";
require_once __DIR__ . "/../../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "Model/Class/GameManager.php";

$gameManager = new \Model\Entity\GameManager();
$action_game = $_GET['action_game'] ?? '';

// ACTION : MISE À JOUR DES CAISSES EXISTANTES
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action_game === 'update_proba') {
    $id = (int)$_POST['id'];
    $slug = $_POST['slug'];
    $probs = [];

    if ($slug === 'pileOuFace') {
        $probs = [
            'edge' => (float)$_POST['edge'],
            'win_multiplier' => (float)$_POST['win_multiplier'],
            'edge_multiplier' => (float)($_POST['edge_multiplier'] ?? 4.0)
        ];
    } elseif ($slug === 'caseOpening') {
        $probs = ['cases' => []];
        foreach ($_POST['case_id'] as $index => $caseId) {
            $caseData = [
                'id' => $caseId,
                'name' => $_POST['case_name'][$index],
                'price' => (float)$_POST['case_price'][$index],
                'items' => []
            ];
            foreach (['gris', 'bleu', 'violet', 'rouge', 'gold'] as $rarity) {
                $caseData['items'][$rarity] = [
                    'mult' => (float)$_POST['mult'][$index][$rarity],
                    'prob' => (int)$_POST['prob'][$index][$rarity]
                ];
            }
            $probs['cases'][] = $caseData;
        }
    }
    $gameManager->setProbs($id, $probs);
    header("Location: /~uapv2500805/admin/Controller/controller_admingames.php");
    exit();
}


// ACTION : SUPPRIMER UNE CAISSE
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action_game === 'delete_case') {
    $id = (int)$_GET['id']; // L'ID du jeu (Case Opening)
    $case_id = $_GET['case_id']; // L'ID spécifique de la caisse dans le JSON

    // 1. On récupère les probabilités actuelles
    $game = $gameManager->getGameDataId($id);
    $currentProbs = is_string($game['probabilities']) ? json_decode($game['probabilities'], true) : $game['probabilities'];

    if (isset($currentProbs['cases'])) {
        // 2. On filtre le tableau pour garder toutes les caisses SAUF celle qu'on veut supprimer
        $currentProbs['cases'] = array_filter($currentProbs['cases'], function($case) use ($case_id) {
            return $case['id'] !== $case_id;
        });

        // On réindexe le tableau (très important en PHP pour que ça reste un tableau JSON propre et non un objet)
        $currentProbs['cases'] = array_values($currentProbs['cases']);

        // 3. On sauvegarde la modification
        $gameManager->setProbs($id, $currentProbs);
    }

    // 4. On redirige vers la page de modification
    header("Location: /~uapv2500805/admin/Controller/controller_admingames.php?action_game=proba&id=" . $id);
    exit();
}


// ACTION : AJOUTER UNE NOUVELLE CAISSE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action_game === 'add_case') {
    $id = (int)$_POST['game_id'];

    // 1. On récupère les données actuelles
    $game = $gameManager->getGameDataId($id);
    $currentProbs = is_string($game['probabilities']) ? json_decode($game['probabilities'], true) : $game['probabilities'];
    if (!isset($currentProbs['cases'])) $currentProbs['cases'] = [];

    // 2. On prépare la nouvelle caisse
    $newCase = [
        'id' => strtolower(str_replace(' ', '_', $_POST['new_case_name'])) . "_" . time(), // ID technique unique
        'name' => $_POST['new_case_name'],
        'price' => (float)$_POST['new_case_price'],
        'items' => []
    ];

    foreach (['gris', 'bleu', 'violet', 'rouge', 'gold'] as $rarity) {
        $newCase['items'][$rarity] = [
            'mult' => (float)$_POST['new_mult'][$rarity],
            'prob' => (int)$_POST['new_prob'][$rarity]
        ];
    }

    // 3. On l'ajoute et on sauvegarde
    $currentProbs['cases'][] = $newCase;
    $gameManager->setProbs($id, $currentProbs);

    header("Location: /~uapv2500805/admin/Controller/controller_admingames.php?action_game=proba&id=" . $id);
    exit();
}

ob_start();
if ($action_game === 'proba') {
    $game = $gameManager->getGameDataId($_GET['id']);
    if (is_string($game['probabilities'])) {
        $game['probabilities'] = json_decode($game['probabilities'], true);
    }
    include '../view/pages/form_proba.php';
} else {
    $gamesList = $gameManager->getAllGames();
    include '../view/pages/admingames.php';
}
$content = ob_get_clean();
include '../view/layout/layout.php';