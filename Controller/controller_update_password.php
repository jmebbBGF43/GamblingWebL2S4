<?php
require_once "../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";
require_once ROOT_DIR . "Model/Class/UserDB.php";

use Model\Entity\UserDB;

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité : Jeton CSRF invalide. Action bloquée.");
    }
    $oldPassword = $_POST['old_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $userDB = new UserDB();
    $userData = $userDB->getUserById($_SESSION['user_id']);

    try {
        if ($newPassword !== $confirmPassword) {
            throw new \Exception("Les nouveaux mots de passe ne correspondent pas.");
        }
        if ($oldPassword === $newPassword) {
            throw new \Exception("Le nouveau mot de passe doit être différent de l'ancien.");
        }
        if (!$userData || !password_verify($oldPassword, $userData['password_hash'])) {
            throw new \Exception("L'ancien mot de passe est incorrect.");
        }
        $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $userDB->updatePassword($_SESSION['user_id'], $newHash);

        $_SESSION['pwd_success'] = "Ton mot de passe a été mis à jour avec succès !";

    } catch (\Exception $e) {
        $_SESSION['pwd_error'] = $e->getMessage();
    }
}

header("Location: " . BASE_URL . "Controller/controller_menu.php?user_pageID=parameter");
exit();