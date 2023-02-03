<?php

namespace App\Controllers;

use App\Frame\Autentification;
use App\Models\Locacion;
use App\Models\Locales;
use App\Models\Propietarios;
use App\Models\Usuarios;

class Database{
    private $autentification;
    private $locales;
    private $locacion;
    private $propietarios;
    private $usuarios;

    public function __construct(
        Autentification $autentification,
        Locales $locales,
        Locacion $locacion,
        Propietarios $propietarios,
        Usuarios $usuarios
    )
    {
        $this->autentification = $autentification;
        $this->usuarios = $usuarios;
        $this->locales = $locales;
        $this->locacion = $locacion;
        $this->propietarios = $propietarios;
    }

    public function view(){
        $user = $this->autentification->getUser();
        return [
            'title' => 'Respaldos de bases de Datos',
            'template' => 'ui/respaldos.html.php',
            'variables' => [
                'user' => $user
            ]
        ];
    }

    public function generate(){
        date_default_timezone_set('America/Guayaquil');
        $date = new \DateTime();
        $nombre = $date->getTimestamp() . '-backup.sql';
        $dir = __DIR__ . '/../backups/';
        $output = $dir . $nombre;
        $dirTemplate =__DIR__ .'/../config/'. 'template/template_gad_gda.sql';
        $templateSQL = file_get_contents($dirTemplate);
        /** Se remplazara los datos de la base como las locaciones */
        $dbLocaciones = $this->locacion->select();
        $dbLocales = $this->locales->select();
        $dbPropietarios = $this->propietarios->select();
        $dbUsuarios = $this->usuarios->select();
        $respalA = '';
        $respalB = '';
        $respalC = '';
        $respalD = '';
        foreach($dbLocaciones as $locacion){
            echo "!-- <br>";
            $respalA .= "('$locacion->id','$locacion->nombre','$locacion->link'),";
        }
        foreach($dbLocales as $local){
            $respalB .= 'INSERT INTO `locales` VALUES'; 
            $conta = $local->contabilidad === NULL ? 'NULL' : $local->contabilidad;
            $respalB .= "('$local->id','$local->nombre','$local->tipo','$local->imagen','$local->id_locacion','$local->id_propietario','$local->id_usuario','$conta');";
            
        }
        foreach($dbPropietarios as $propietario){
            $celular = $propietario->celular === NULL ? 'NULL' : $propietario->celular;
            $respalC .= "('$propietario->id','$propietario->cedula','$propietario->nombre','$propietario->ruc','$propietario->anonimo','$celular'),";
            
        }
        foreach($dbUsuarios as $usuario){
            $respalD .= "('$usuario->id','$usuario->nombre','$usuario->clave','$usuario->permisos','$usuario->estado','$usuario->fecha'),";
            
        }
        $respalA = rtrim($respalA,',') . ';';
        $respalC = rtrim($respalC,',') . ';';
        $respalD = rtrim($respalD,',') . ';';
        $respalB = str_replace('\'NULL\'','NULL',$respalB);
        $respalC = str_replace('\'NULL\'','NULL',$respalC);        
        $templateSQL = str_replace('%valores_locacion%',$respalA,$templateSQL);
        $templateSQL = str_replace('%valores_locales%',$respalB,$templateSQL);
        $templateSQL = str_replace('%valores_propietarios%',$respalC,$templateSQL);
        $templateSQL = str_replace('%valores_usuarios%',$respalD,$templateSQL);
        file_put_contents($output,$templateSQL);
       header('location: /list/respaldos/db');
       exit();
    }

    public function list(){
        
        return [
            'title' => 'Lista de Respaldos',
            'template' => 'ui/listRespaldos.html.php',
        ];
    }
}