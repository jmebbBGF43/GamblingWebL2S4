<?php
require_once "../configuration/config.php";
require_once "../Model/ConnexionDB.php";
require_once "../Model/Class/User.php";
require_once "../Model/Class/UserDB.php";

use Model\Entity\User;
use Model\Entity\UserDB;

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['login_id'] ?? null;
    $password = $_POST['login_password'] ?? null;
    $remember = isset($_POST['remember_me']);

    try {
        if (empty($username) || empty($password)) {
            throw new \Exception("Veuillez remplir tous les champs");
        }
        $user = new User($username, $password);
        $userDB = new UserDB();
        $userData = $userDB->verifyUser($user);
        if (!$userData) {
            throw new \Exception("Connexion échouée, Username ou Mot de passe incorrect");
        }
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['username'] = $userData['username'];
        $_SESSION['role'] = $userData['role'];
        if ($remember) {
            setcookie('remember_user', $userData['id'], time() + (86400 * 30), "/");
        }
        header('Location: ../index.php');
        exit();

    } catch (\Exception $e) {
        $error_message = "<p class='text-red-500 text-2xl font-bold mb-2 text-center mt-4 mb-4'>" . $e->getMessage() . "</p>";
    }
}

$url = 'login';
include "../view/layout_reglog.php";

if (!empty($error_message)) {
    echo $error_message;
}