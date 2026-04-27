<?php
require_once "../configuration/config.php";

ob_start();
include "../view/pages/sitemap.php";
$content = ob_get_clean();

include "../view/layout.php";