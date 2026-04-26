<?php
require_once "../configuration/config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

$page = $_GET['page'] ?? 'home';

ob_start();

switch ($page) {
    case 'users':
        include 'Controller/controller_adminusers.php';
        break;
    case 'games':
        include 'Controller/controller_admingames.php';
        break;
    case 'faq':
        include 'Controller/controller_adminfaq.php';
        break;
    default:
        include 'view/pages/home.php';
        break;
}

$content = ob_get_clean();

include "view/layout/layout.php";