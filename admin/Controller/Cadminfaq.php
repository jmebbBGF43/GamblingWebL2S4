<?php

require_once "../../configuration/config.php";
include ROOT_DIR . "configuration/temp_game.php";

ob_start();

include '../view/pages/adminfaq.php';

$content = ob_get_clean();

include '../view/layout/layout.php';
