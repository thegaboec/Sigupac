<?php

namespace App\Application;

class Utiles{

    public static function loadEnv($dir){
        if(!file_exists($dir . '/.env')){
            throw new \Exception('Not exist file .env in main direccion');
        }

        $stringEnv = file_get_contents($dir . '/.env');
        $separateString = preg_split('/\n|\r/',$stringEnv);
        $arrayVariables = array_filter(
            $separateString,
            function ($string) {
                return $string !== '' ? true: false;
            }
        );
        // $arrayVariables = array_filter(
        //     $arrayVariables, 
        //     function($string){
        //         return !str_contains($string,'#');
        //     }
        // );
        
        foreach($arrayVariables as $variable){
            $variable = str_replace('"','',$variable);
            list($key,$value) = preg_split('/=/', trim($variable));
            $_ENV[$key] = $value;
        }


    }
}