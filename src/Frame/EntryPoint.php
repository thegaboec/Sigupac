<?php

namespace App\Frame;

use App\Application\RoutesApplication;

/**
 * Es la clase del punto de entrada que toma las
 * rutas y se comunica con las routas de la aplicacion 
 */
class EntryPoint{
    /**
     * Es la ruta que se optiene del servidor
     * 
     * @var string
     */
    private $route;
    /**
     * Es el metodo por el cual se realiza la solicitud
     * 
     * @var string 
     */
    private $method;
    /**
     * Es la instancia de todas las rutas que contiene la aplicacion
     * 
     * @var  RoutesApplication
     */
    private $routesApplication;

    public function __construct(
        string $route,
        string $method,
        RoutesApplication  $routesApplication
    )
    {
        $this->route = $route;
        $this->method = $method;
        $this->routesApplication = $routesApplication;
        $this->verifyRoutes();
    }
    /**
     * Este metodo verifica que si la ruta se escribio 
     * en mayusculas lo transforme a minusculas para que 
     * el motor de busqueda lo trate como la direccion 
     * del servidor
     */
    private function verifyRoutes(){
        if(strtolower($this->route) !== $this->route){
            http_response_code(301); // Le dice al motor de busqueda que tome la ruta como parte del mismo servidor
            header('location: ' . strtolower($this->route));
        }
    }
    /**
     * Este metodo carga las vistas modulares
     * antes de renderizarze a la vista principal
     * 
     * @param string $template el ruta del archivo example.html.php
     * @param array $variables son las variables de esa vista
     */

    private function loadTemplate($template, $variables = []){
        extract($variables);
        ob_start(); // abre el buffer para guardar el template
        include __DIR__ . '/../Views/' . $template; // incluimos el archivo para que se guarde en el buffer
        return ob_get_clean(); // regresa la vista renderizada que se guardo en el buffer con las variables

    }

    /**
     * Este metodo pone a correr todo el funcionamiento 
     * del aplicativo
     */
    public function run(){
        /**
         * Contiene todas las rutas de la aplicacion 
         * con los metodos de consulta GET y POST en un array
         * 
         * @var array 
         */
        $routes = $this->routesApplication->getRoutes();
        if(!isset($routes[$this->route])){ // Si no existe la ruta 
            header('location: /error/404');// Que le redirecione a una pagina que muestra el error 404  
        }

        if(!isset($routes[$this->route][$this->method])){ // Si existe la ruta pero no el metodo
            header('location: /error/404');               // que tambien redirecione a un error 404
        }
        /**
         * Las variable $controller 
         * contiene el controlador designado de esa ruta
         * 
         * @var Api
         */
        $controller = $routes[$this->route][$this->method]['controller'];
        /**
         * Continen la accion de ese controlador 
         * o conocidos como el metodo
         * 
         * @var method
         */
        $action  = $routes[$this->route][$this->method]['action'];
        /**
         * $result contiene todo lo que regresa el controlador
         * 
         * @var array
         */
        $result = $controller->$action();

        if(isset($routes[$this->route]['login']) && !$this->routesApplication->autentification()->verifySession()){
            header('location: /error');
        }
        
        if(isset($routes[$this->route]['permission']) && !$this->routesApplication->hasPermission($routes[$this->route]['permission'])){
            header('location: /error');
        }
        $title = $result['title']; // Contiene el titulo de la pagina
        
        if(isset($result['variables'])){ // se compreba si tiene variables para cargar las variables en el template
            $content = $this->loadTemplate($result['template'],$result['variables']);
        }else{
            $content = $this->loadTemplate($result['template']);
        }
        $user = $this->routesApplication->autentification()->getUser();

        // por ultimo solo se imprime la vista
        echo $this->loadTemplate(
            'template/layout.html.php',
            [
                'title' => $title,
                'content' => $content,
                'user' => $user
            ]
        );


    }
}