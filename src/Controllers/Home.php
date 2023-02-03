<?php

namespace App\Controllers;

class Home {
    public function home(){
        return [
            'title' => 'Home',
            'template' => 'ui/home.html.php'
        ];
    }
    public function instruccion(){
        return [
            'title' => 'Instrucciones',
            'template' => 'ui/instruccion.html.php'
        ];
    }

    public function error(){
        return [
            'title' => 'ERROR',
            'template' => 'ui/error.html.php'
        ];
    }
    public function error404(){
        http_response_code(404);
        return [
            'title' => 'Error 404',
            'template' => 'ui/error404.html.php'
        ];
    }
}