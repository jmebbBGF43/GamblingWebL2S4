<?php
ob_start();
include '../view/pages/adminusers.php';
$content = ob_get_clean();

include '../view/layout/layout.php';


