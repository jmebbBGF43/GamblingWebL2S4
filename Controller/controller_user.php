<?php
require_once "../model/class/User.php";
require_once "../configuration/config.php";

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
    }
}
catch (Exception $e) {
    echo $e->getMessage();
}