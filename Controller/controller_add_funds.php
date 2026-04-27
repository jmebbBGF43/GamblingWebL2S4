<?php
require_once "../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "Model/Class/UserDB.php";

use Model\Entity\UserDB;
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "connexion");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité : Jeton CSRF invalide. Action bloquée.");
    }
    $amountToAdd = floatval($_POST['amount'] ?? 0);
    if ($amountToAdd > 0) {
        try {
            $userDB = new UserDB();
            $userData = $userDB->getUserById($_SESSION['user_id']);
            if ($userData) {
                $newBalance = $userData['credits'] + $amountToAdd;
                $userDB->updateUserCredits($_SESSION['user_id'], $newBalance);
                $_SESSION['payment_success'] = "+ " . number_format($amountToAdd, 2, '.', ' ') . " € ajoutés avec succès !";
            } else {
                $_SESSION['payment_error'] = "Erreur : Compte introuvable.";
            }

        } catch (\Exception $e) {
            $_SESSION['payment_error'] = "Erreur serveur : impossible de traiter le paiement.";
        }
    } else {
        $_SESSION['payment_error'] = "Le montant doit être supérieur à 0.";
    }
}
header("Location: " . BASE_URL . "paiment");;
exit();