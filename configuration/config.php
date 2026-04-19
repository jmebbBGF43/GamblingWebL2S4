<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define('ROOT_DIR', dirname(__DIR__) . '/');
const BASE_URL = 'https://pedago.univ-avignon.fr/~uapv2500969/';