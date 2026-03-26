<?php

use Model\ConnexionDB;
use Model\Entity\User;
use Model\Entity\UserDB;

require_once "../Model/ConnexionDB.php";
require_once "../Model/Class/User.php";
require_once "../Model/Class/UserDB.php";
require_once "../Model/ConnexionDB.php";


if (isset($_POST['confirmpassword'])) {
    $confirmpassword = $_POST['confirmpassword'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
}
if (isset($_POST['username'])) {
    $username = $_POST['username'];
}

try {
    if ($password != $confirmpassword) {
        throw new Exception("Les mots de passe ne correspondent pas");
    } else {
        $user = new User($username, $password);
        $userDB = new UserDB();
        $userDB->insertUser($user);
    }
}
catch (Exception $e) {
    echo $e->getMessage();
}
