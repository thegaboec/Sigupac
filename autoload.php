<?php
function autoload ($className){
    $className = str_replace('App\\','src/',$className);
    $dir = str_replace('\\','/',$className) . '.php';
    include __DIR__ . '/' . $dir;
}

//spl_autoload_register('autoload');