<?php
require_once "vendor/autoload.php";

// lê o .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// carrega o nosso servidor
require_once "src/server.php";
