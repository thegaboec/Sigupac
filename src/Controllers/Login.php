<?php
namespace App\Controllers;

use App\Frame\Autentification;
use App\Models\Usuarios;

class Login{
    private $autentification;
    public function __construct(
        Autentification $autentification
    )
    {
        $this->autentification= $autentification;
    }

    public function login(){
        return [
            'title' => 'Iniciar Sessión',
            'template' => 'ui/login.html.php'
        ];
    }

    public function saveLogin(){
        $res = $this->autentification->verifyLogin($_POST['cedula'],$_POST['password']);
        if($res){
            $user = $this->autentification->getUser();
            if($user->permisos == Usuarios::ADMINISTRADOR){
                $_SESSION['cargo'] = Usuarios::ADMINISTRADOR;
            }else if($user->permisos == Usuarios::JEFE_PLANTA){
                $_SESSION['cargo'] = Usuarios::JEFE_PLANTA;
            }
            header('location: /');
            exit();
        }

        return [
            'title' => 'Login Admin',
            'template' => 'ui/login.html.php',
            'variables' => [
                'error' => 'No se ingreso correctamento los datos, pruebe nuevamente'
            ]
        ];
    }
    public function logOut(){
        unset($_SESSION);
        session_destroy();
        header('location: /');
    }
}