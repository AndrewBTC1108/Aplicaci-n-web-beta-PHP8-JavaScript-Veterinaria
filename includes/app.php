<?php

use Dotenv\Dotenv;
use Model\ActiveRecord;
//cargamos autolad
require __DIR__ . '/../vendor/autoload.php';

//añadimos Dotenv
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);