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

        if (empty($username) || empty($password)) {
            throw new Exception("Veuillez remplir tous les champs");
        }

        // Vérification de la correspondance des mots de passe
        if ($password !== $confirmpassword) {
            throw new Exception("Les mots de passe ne correspondent pas");
        }

        $user = new User($username, $password);
        $userDB = new UserDB();
        $userDB->insertUser($user);

        echo "<p class='text-white text-2xl font-bold mb-2 text-center mt-4 mb-4'>Compte créé !</p>";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}