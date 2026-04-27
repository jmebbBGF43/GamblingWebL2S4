<?php
require_once "../configuration/config.php";

$_SESSION = array();
session_destroy();

if (isset($_COOKIE['remember_user'])) {
    setcookie('remember_user', '', time() - 3600, '/');
}

header("Location: " . BASE_URL . "home");
exit();