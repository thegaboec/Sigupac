<?php

namespace App\Controllers;

class Apariencia{

    public function view($variables= []){

        return [
            'title' => 'Cambio de Logotipo',
            'template' => 'ui/apariencia.html.php',
            'variables' => $variables
        ];
    }
    public function cambioImagen(){
        if(empty($_FILES['imagen']['name'])){
            return $this->view(
                ['error' => 'Error no ingreso ninguna imagen']
            );
        }
        $date = time();
        $tmp = $_FILES['imagen']['tmp_name'];
        $name = $date . $_FILES['imagen']['name'];
        $direccionJson = './src/Includes/logos.json';
        $DirecionImage = './src/public/img/';
        $outputImage = $DirecionImage . $name;

        if(move_uploaded_file($tmp,$outputImage)){ // mueve la imagen guardada en el espacio temporal hacia la carpeta img permanentemente
            $jsonImage = file_get_contents($direccionJson);// traemos el archivo json que contien la url de la imagen del logo
            $dataImage = json_decode($jsonImage,true);
            $dataImage['img'] = ltrim($outputImage,'.'); // le damos la nueva direccion del logo
            file_put_contents($direccionJson,json_encode($dataImage)); 
            return $this->view(['success' => 'Se cambio correctamente el logotipo']);
        }else{
            return $this->view(['error' => 'Error ocurrio un proble al guardar la imagen intente nuevamente']);
        }
    }
}
