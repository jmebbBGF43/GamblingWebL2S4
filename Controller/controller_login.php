<?php

use Model\ConnexionDB;
use Model\Entity\User;
use Model\Entity\UserDB;


require_once "../Model/ConfigurationDB.php";
require_once "../Model/ConnexionDB.php";
require_once "../Model/Class/User.php";
require_once "../Model/Class/UserDB.php";

$url = 'login';
include "../view/layout_reglog.php";

$username = $_POST['login_id'] ?? null;
$password = $_POST['login_password'] ?? null;

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($username) || empty($password)) {
            throw new Exception("<p class='text-red-500 text-2xl font-bold mb-2 text-center mt-4 mb-4'>Veuillez remplir tous les champs</p>");
        }

        $user = new User($username, $password);
        $userDB = new UserDB();

        $result = $userDB->verifyUser($user);
        if (!$result) {
            throw new Exception("<p class='text-red-500 text-2xl font-bold mb-2 text-center mt-4 mb-4'>Connection a échouée, Username ou Mot de pass incorrecte </p>");
        }
        echo "<p class='text-white text-2xl font-bold mb-2 text-center mt-4 mb-4'>Vous etes connecté</p>";
        header('Location: ../index.php');
        exit();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}