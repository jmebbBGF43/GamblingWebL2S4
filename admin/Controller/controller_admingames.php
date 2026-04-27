<?php
require_once "controller_adminlogin.php";
require_once __DIR__ . "/../../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "Model/Class/GameManager.php";

$gameManager = new \Model\Entity\GameManager();
$action_game = $_GET['action_game'] ?? '';
// ACTION : BASCULER LE STATUT ACTIF / INACTIF D'UN JEU
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action_game === 'toggle_status') {
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        // Appel de la méthode pour inverser l'état
        $gameManager->toggleGameStatus($id);
    }

    header("Location: ". BASE_URL ."admin/Controller/controller_admingames.php");
    exit();
}
// ACTION : MISE À JOUR DES CAISSES EXISTANTES
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action_game === 'update_proba') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité CSRF.");
    }
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
    header("Location: ". BASE_URL ."admin/Controller/controller_admingames.php");
    exit();
}


// ACTION : SUPPRIMER UNE CAISSE
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action_game === 'delete_case') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité CSRF.");
    }
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
    header("Location: ". BASE_URL ."admin/Controller/controller_admingames.php?action_game=proba&id=" . $id);
    exit();
}


// ACTION : AJOUTER UNE NOUVELLE CAISSE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action_game === 'add_case') {
    // 1. Sécurité CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité CSRF.");
    }

    $id = (int)$_POST['game_id'];
    $newName = trim($_POST['new_case_name']);

    // On récupère les données actuelles
    $game = $gameManager->getGameDataId($id);
    $currentProbs = is_string($game['probabilities']) ? json_decode($game['probabilities'], true) : $game['probabilities'];
    if (!isset($currentProbs['cases'])) $currentProbs['cases'] = [];

    // 2. Vérification du nom en doublon
    foreach ($currentProbs['cases'] as $c) {
        if (strtolower($c['name']) === strtolower($newName)) {
            $_SESSION['admin_error'] = "Une caisse nommée '$newName' existe déjà !";
            header("Location: controller_admingames.php?action_game=proba&id=" . $id);
            exit();
        }
    }

    // 3. Vérification des probabilités (exactement 100%)
    $totalProb = 0;
    foreach (['gris', 'bleu', 'violet', 'rouge', 'gold'] as $rarity) {
        $totalProb += (int)$_POST['new_prob'][$rarity];
    }

    if ($totalProb !== 100) {
        $_SESSION['admin_error'] = "Impossible d'ajouter. La somme des probabilités est de $totalProb% au lieu de 100% !";
        header("Location: controller_admingames.php?action_game=proba&id=" . $id);
        exit();
    }

    // 4. On prépare et ajoute la nouvelle caisse
    $newCase = [
        'id' => strtolower(str_replace(' ', '_', $newName)) . "_" . time(),
        'name' => $newName,
        'price' => (float)$_POST['new_case_price'],
        'items' => []
    ];

    foreach (['gris', 'bleu', 'violet', 'rouge', 'gold'] as $rarity) {
        $newCase['items'][$rarity] = [
            'mult' => (float)$_POST['new_mult'][$rarity],
            'prob' => (int)$_POST['new_prob'][$rarity]
        ];
    }

    $currentProbs['cases'][] = $newCase;
    $gameManager->setProbs($id, $currentProbs);

    $_SESSION['admin_success'] = "La caisse '$newName' a bien été ajoutée !";
    header("Location: controller_admingames.php?action_game=proba&id=" . $id);
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