<?php

namespace App\Controllers;

use App\Frame\Autentification;
use App\Models\Usuarios;

class Agentes {
    private $autentification;
    private $agentes;
    private $date;
    public function __construct(
       Usuarios $agentes,
       Autentification $autentification
    )
    {
        $this->agentes = $agentes;
        $this->autentification= $autentification;
    }

    public function view($variables=[]){
        if(empty($variables)){
            return [
                'title' => 'Ingresar un Agente',
                'template' => 'ui/agentes.html.php'
            ];
        }
        
        return [
            'title' => 'Ingresar un Agente',
            'template' => 'ui/agentes.html.php',
            'variables' => $variables
        ];
    }

    public function saveAgente(){
        if(empty($_POST['cedula']) ||
            empty($_POST['nombre']) ||
            empty($_POST['password'])
        ){
            return $this->view([
                'error' => 'Uno de los campos no ingreso'
            ]);
        }
        $dataAgentes = [
            'id' => $_POST['cedula'],
            'nombre' => $_POST['nombre'],
            'clave' => base64_encode($_POST['password']),
            'permisos' => Usuarios::AGENTE_MUNICIPAL,
            'estado' => 'activo',
            'fecha' => $this->getDateLocal()
        ];
        
        try{
            $this->agentes->insert($dataAgentes);
            return $this->view([
                'success' => 'Se guardo correctamente al agente' 
            ]);
        }catch(\PDOException $e){
            return $this->view([
                'error' => 'Error no se pudo guardar por ' . $e->getMessage() 
            ]);
        }
    }
    public function list(){
        $agentes =  $this->agentes->selectFromColumn('permisos',Usuarios::AGENTE_MUNICIPAL);
        return [
            'title' => 'Lista de Agentes',
            'template' => 'ui/listAgentes.html.php',
            'variables' => [
                'agentes' => $agentes
            ]
        ];
    }
    public function removeAgente(){
        $agentes =  $this->agentes->selectFromColumn('permisos',Usuarios::AGENTE_MUNICIPAL);
        return [
            'title' => 'Habilitar/Deshabilitar Agentes',
            'template' => 'ui/removeAgentes.html.php',
            'variables' => [
                'agentes' => $agentes
            ]
        ];
        
    }
    public function saveRemoveAgente(){
        $dataAgentes = [];
        foreach($_POST as $usuario){
            if(isset($usuario['cargo'])){
                array_push($dataAgentes,$usuario);
                
            }
        }
        
       

        $error = '';
        foreach($dataAgentes as $personal){
            $person = $this->agentes->selectFromColumn('id',$personal['id'])[0];
            $estado = '';
            if($person->estado === 'activo'){
                $estado = 'inactivo';
            }else{
                $estado = 'activo';
            }

            $dataFinalPlanta = [
                'estado' => $estado,
                'id' => $personal['id']
            ];

            try{
                $this->agentes->update($dataFinalPlanta);
            }catch(\PDOException $e){
                $error = 'Error: ' . $e->getMessage();
            }
        }
        return $this->removeAgente();
    }

    public function addJefePlanta($variables=[]){
        if(empty($variables)){
            return [
                'title' => 'Agregar Jefe de Planta',
                'template' => 'ui/personalPlanta.html.php'
            ];
        }
        
        return [
            'title' => 'Agregar Jefe de Planta',
            'template' => 'ui/personalPlanta.html.php',
            'variables' => $variables
        ];
    }
    public function saveJefePlanta(){
        if(empty($_POST['cedula']) ||
            empty($_POST['nombre']) ||
            empty($_POST['password'])
        ){
            return $this->addJefePlanta([
                'error' => 'Uno de los campos no ingreso'
            ]);
        }
        $dataJefePlanta = [
            'id' => $_POST['cedula'],
            'nombre' => $_POST['nombre'],
            'clave' => password_hash($_POST['password'],PASSWORD_DEFAULT),
            'permisos' => Usuarios::JEFE_PLANTA,
            'estado' => 'activo',
            'fecha' => $this->getDateLocal(),
        ];
        try{
            $this->agentes->insert($dataJefePlanta);
           return $this->addJefePlanta([
                'success' => 'Se inserto correctamente el usuario'
            ]);
        }catch(\PDOException $e){
           return $this->addJefePlanta([
                'error' => 'Error: ' . $e->getMessage() 
            ]);
        }
    }
    public function bajaJefePlanta($variables= [],$option = true){
        $personales = $this->agentes->selectFromColumn('permisos',Usuarios::JEFE_PLANTA);
            $variables = [
                'personales' => $personales
            ]; 
        if(!$option){
            $variables['error'] = $variables;       
        }

            return [
            'title' => 'Habilitar/Deshabilitar Jefe de Planta',
            'template' => 'ui/bajaPersonalPlanta.html.php',
            'variables' => $variables
        ];
    }

    public function saveBajaJefePlanta(){
        $dataJefePlanta = [];
        foreach($_POST as $usuario){
            if(isset($usuario['cargo'])){
                array_push($dataJefePlanta,$usuario);
                
            }
        }
        
       

        $error = '';
        foreach($dataJefePlanta as $personal){
            $person = $this->agentes->selectFromColumn('id',$personal['id'])[0];
            $estado = '';
            if($person->estado === 'activo'){
                $estado = 'inactivo';
            }else{
                $estado = 'activo';
            }

            $dataFinalPlanta = [
                'estado' => $estado,
                'id' => $personal['id']
            ];

            try{
                $this->agentes->update($dataFinalPlanta);
            }catch(\PDOException $e){
                $error = 'Error: ' . $e->getMessage();
            }
        }
        return $this->bajaJefePlanta($error,false);
       
    }

    public function cambioClave($variables = []){
        return [
            'title' => 'Cambio de clave',
            'template' => 'ui/cambioClave.html.php',
            'variables' => $variables
        ];
    }

    public function saveCambioClave(){
        if(empty($_POST['actual'])
            || empty($_POST['newpass'])
            || empty($_POST['repitpass'])
        ){
            return $this->cambioClave(['error' => 'Error no ingreso uno de los campos']);
        }
        $user = $this->autentification->getUser();
        if(!password_verify($_POST['actual'],$user->clave)){
            return $this->cambioClave(['error' => 'La contraseña no coincide con el usuario actual']);
        }
        
        if($_POST['newpass'] !== $_POST['repitpass']){
            return $this->cambioClave(['error' => 'Error no coinciden las contraseñas nuevas']);
        }
        $password = password_hash($_POST['newpass'],PASSWORD_DEFAULT);
        try{
            $dataUser = [
                'clave' => $password,
                'id' => $user->id
            ];
            $this->agentes->update($dataUser);
            $_SESSION['password'] = $password;
            return $this->cambioClave(['success' => 'Se cambio correctamente la contraseña']);
        }catch(\PDOException $e){
            return $this->cambioClave(['error' => 'Error: ' . $e->getMessage()]);
        }

    }
    private function getDateLocal(){
        date_default_timezone_set('America/Guayaquil');
        $this->date = new \DateTime();

        return $this->date->format('Y-m-d');
    }

}