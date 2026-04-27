<?php
session_start();
require_once "../../configuration/config.php";
require_once ROOT_DIR . "Model/ConnexionDB.php";

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: " . BASE_URL . "admin/utilisateurs");
    exit();
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erreur de sécurité : Jeton CSRF invalide.";
    } else {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $stmt = \Model\ConnexionDB::getPDO()->prepare("SELECT id, username, password_hash, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            if ($user['role'] === 'admin') {
                // Succès : C'est un admin !
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: " . BASE_URL . "admin/utilisateurs");
                exit();
            } else {
                $error = "Accès refusé : Ce compte n'a pas les droits d'administration.";
            }
        } else {
            $error = "Identifiants incorrects.";
        }
    }
}
include '../view/pages/login.php';