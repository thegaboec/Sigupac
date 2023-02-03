<?php

include __DIR__ . '/vendor/autoload.php';

use App\Application\RoutesApplication;
use App\Application\Utiles;
use App\Frame\EntryPoint;
error_reporting(E_ALL);
ini_set('display_errors', '1');

Utiles::loadEnv(__DIR__);
try {
    $route = ltrim(strtok($_SERVER['REQUEST_URI'],'?'),'/');
    $entryPoint = new EntryPoint($route,$_SERVER['REQUEST_METHOD'],new RoutesApplication);
    $entryPoint->run();
} catch (\PDOException $e) {
    $err = 'Error : ' . $e->getMessage() . ' in ' . $e->getFile() . ' : ' . $e->getLine();
    echo $err;
}


