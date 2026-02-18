<?php

if (isset($_GET['url'])) {
    $page = $_GET['url'];
}
else {
    $page = 'home';
}

$chemin = 'view/pages/'.$page.'.php';

ob_start();

if (file_exists($chemin)) {
    include $chemin;
}

$content = ob_get_clean();

include "view/layout.php";

?>