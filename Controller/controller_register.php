<?php

use Model\ConnexionDB;
use Model\Entity\User;
use Model\Entity\UserDB;


require_once "../Model/ConfigurationDB.php";
require_once "../Model/ConnexionDB.php";
require_once "../Model/Class/User.php";
require_once "../Model/Class/UserDB.php";

$url = 'register';

include "../view/layout_reglog.php";


$username = $_POST['register_username'] ?? null;
$password = $_POST['register_password'] ?? null;
$confirmpassword = $_POST['register_confirmpassword'] ?? null;

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("Erreur de sécurité : Jeton CSRF invalide. Action bloquée.");
        }
        if (empty($username) || empty($password)) {
            throw new Exception("<p class='text-red-500 text-2xl font-bold mb-2 text-center mt-4 mb-4'>Veuillez remplir tous les champs</p>");
        }
        if ($password !== $confirmpassword) {
            throw new Exception("<p class='text-red-500 text-2xl font-bold mb-2 text-center mt-4 mb-4'>Les mots de passe ne correspondent pas</p>");
        }

        $user = new User($username, password_hash($password, PASSWORD_DEFAULT));
        $userDB = new UserDB();
        $userDB->insertUser($user);

        echo "<p class='text-white text-2xl font-bold mb-2 text-center mt-4 mb-4'>Compte créé !</p>";
        header('Location: ../index.php');
        exit();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}