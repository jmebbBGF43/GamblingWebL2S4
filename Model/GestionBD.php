<?php

class GestionBD {

    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("psql:'pedago.univ-avignon.fr';dbname='etd';port='5432'", 'uapv2500805', 'caca');
    }
}
