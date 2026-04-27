<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

define('ROOT_DIR', dirname(__DIR__) . '/');
const BASE_URL = 'https://pedago.univ-avignon.fr/~uapv2500969/';