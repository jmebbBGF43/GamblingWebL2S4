<?php
$page = $_GET['page'] ?? 'home';

ob_start();

switch ($page) {
    case 'users':
        include 'Controller/Cadminusers.php';
        break;
    case 'games':
        include 'Controller/Cadmingames.php';
        break;
    case 'faq':
        include 'Controller/Cadminfaq.php';
        break;
    default:
        include 'view/pages/home.php';
        break;
}

$content = ob_get_clean();

include "view/layout/layout.php";
