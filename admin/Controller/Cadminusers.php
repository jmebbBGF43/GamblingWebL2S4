<?php
require_once "../../configuration/config.php";
include ROOT_DIR . "configuration/bdd_temp.php";

if (isset($_GET['action_user'])) {
    $action_user = $_GET['action_user'];
} else {
    $action_user = '';
}

ob_start();

switch ($action_user) {
    case 'create' :
        include '../view/pages/form_createuser.php';
        break;
    case 'edit' :
        include '../view/pages/form_modif.php';
        break;

    default :
        include '../view/pages/adminusers.php';
        break;

}

$content = ob_get_clean();

include '../view/layout/layout.php';


