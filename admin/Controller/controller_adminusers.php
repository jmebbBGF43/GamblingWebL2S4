<?php

use Model\Entity\User;

require_once "../../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "Model/Class/User.php";
require_once ROOT_DIR . "Model/Class/UserDB.php";

// 1. On inclut le GameManager pour pouvoir calculer les bénéfices
require_once ROOT_DIR . "Model/Class/GameManager.php";

$userDB = new \Model\Entity\UserDB();
$gameManager = new \Model\Entity\GameManager(); // Instanciation du GameManager

$action_user = $_GET['action_user'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action_user === 'update') {
    $userDB->updateUser(
        $_POST['update_id'],
        $_POST['update_username'],
        $_POST['update_credits'],
        $_POST['update_role'],
        isset($_POST['update_is_banned']),
        isset($_POST['update_can_play']),
        isset($_POST['update_can_transact'])
    );
    header("Location: controller_adminusers.php");
    exit();
}

ob_start();

switch ($action_user) {
    case 'delete':
        $userDB->deleteUser($_GET['id']);
        header("Location: controller_adminusers.php");
        exit();

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Vérification de sécurité CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Erreur de sécurité : Jeton CSRF invalide.");
            }

            $username = trim($_POST['create_username']);
            $password = $_POST['create_password'];
            $credits = floatval($_POST['create_credits']);
            $role = $_POST['create_role'];

            if (!empty($username) && !empty($password)) {
                try {
                    // On crée l'objet User avec le mot de passe hashé
                    $user = new User($username, password_hash($password, PASSWORD_DEFAULT), $credits, $role);

                    // Insertion en base
                    $userDB->insertUser($user);

                    // Redirection propre vers la liste des utilisateurs
                    header("Location: controller_adminusers.php");
                    exit();
                } catch (\Exception $e) {
                    die("Erreur lors de la création : " . $e->getMessage());
                }
            }
        }
        include '../view/pages/form_createuser.php';
        break;

    case 'edit':
        $u = isset($_GET['id']) ? $userDB->getUserById($_GET['id']) : null;
        include '../view/pages/form_modif.php';
        break;

    default:
        // C'est ici que l'on charge la vue principale du tableau de bord admin
        $users = $userDB->getAllUsers();

        // 2. On récupère les bénéfices totaux du casino avant d'afficher la page
        $casinoProfit = $gameManager->getCasinoProfits();

        include '../view/pages/adminusers.php';
        break;
}

$content = ob_get_clean();
include '../view/layout/layout.php';