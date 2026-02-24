<?php
require_once "configuration/config.php";
ob_start();
include 'view/pages/home.php';
$content = ob_get_clean();

include "view/layout.php";
