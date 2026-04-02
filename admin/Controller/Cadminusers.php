<?php

use Model\Entity\User;

require_once "../../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "Model/Class/UserDB.php";

$userDB = new \Model\Entity\UserDB();
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
    header("Location: Cadminusers.php");
    exit();
}

ob_start();

switch ($action_user) {
    case 'delete':
        $userDB->deleteUser($_GET['id']);
        header("Location: Cadminusers.php");
        exit();
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user = new User($_POST['create_username'], password_hash($_POST['create_password'], PASSWORD_DEFAULT), (int)$_POST['create_credits'], $_POST['create_role']); // (Ou new User() si ta classe est bien configurée)

            $userDB->insertUser($user);

            header("Location: admin/Controller/Cadminusers.php");
            exit();
        }
        include '../view/pages/form_createuser.php';
        break;
    case 'edit':
        $u = isset($_GET['id']) ? $userDB->getUserById($_GET['id']) : null;
        include '../view/pages/form_modif.php';
        break;
    default:
        $users = $userDB->getAllUsers();
        include '../view/pages/adminusers.php';
        break;
}

$content = ob_get_clean();
include '../view/layout/layout.php';