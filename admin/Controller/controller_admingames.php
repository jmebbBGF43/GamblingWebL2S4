<?php

require_once "../../configuration/config.php";
include ROOT_DIR . "configuration/temp_game.php";

if (isset($_GET['action_game'])) {
    $action_game = $_GET['action_game'];
} else {
    $action_game = '';
}

ob_start();

switch ($action_game) {
    case 'addgame':
        include '../view/pages/form_addgame.php';
        break;

    case 'proba' :
        include '../view/pages/form_proba.php';
        break;

    default :
        include '../view/pages/admingames.php';
        break;
}

$content = ob_get_clean();

include '../view/layout/layout.php';
