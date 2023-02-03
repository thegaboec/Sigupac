<?php
namespace App\Application;

use App\Controllers\Agentes;
use App\Controllers\Apariencia;
use App\Controllers\Api;
use App\Controllers\Database;
use App\Controllers\Home;
use App\Controllers\Login;
use App\Controllers\Planta;
use App\Frame\Autentification;
use App\Frame\Routes;
use App\Models\Locacion;
use App\Models\Locales;
use App\Models\Propietarios;
use App\Models\Usuarios;

/**
 * La clase contiene el direcionamiento de las rutas hacia los 
 * controladores 
 */
class RoutesApplication implements Routes {
    /**
     * Son los usuarios como el administrador
     * 
     * @var Usuarios
     */
    private $usuarios;
    /**
     * Son los locales ingresados
     * 
     * @var Locales
     */
    private $locales;
    /**
     * Son los links de la locaciones de GDA
     * 
     * @var  Locacion
     */
    private $locacion;
    /**
     * Son los propietarios de los locales comerciales
     * 
     * @var Propietarios
     */
    private $propietarios;
    /**
     * Sirve para verificar que un usuario ingreso correctamente
     * sus datos para logearse
     * 
     * @var 
     */
    private $autentification;
    public function __construct()
    {
       $this->usuarios = new Usuarios;
       $this->locacion = new Locacion;
       $this->propietarios = new Propietarios;
       $this->locales = new Locales($this->propietarios);
       $this->autentification = new Autentification($this->usuarios,'id','clave');

    }

    /**
     * Contienen todas las rutas
     */
    public function getRoutes(): array
    {
        $apiController = new Api(
            $this->usuarios,
            $this->locales,
            $this->locacion,
            $this->propietarios
        );
        $homeController = new Home;
        $loginController = new Login($this->autentification);
        $agentesController = new Agentes($this->usuarios,$this->autentification);
        $databseController = new Database(
            $this->autentification,
            $this->locales,
            $this->locacion,
            $this->propietarios,
            $this->usuarios
        );
        $aparienciaController = new Apariencia;
        $plantaController = new Planta($this->usuarios,$this->locales,$this->propietarios);

        return [
            '' => [
                'GET' => [
                    'controller' => $homeController,
                    'action' => 'home'
                ]
                ],
            'documentation/api' => [
                'GET' => [
                    'controller' => $apiController,
                    'action' => 'documentation'
                ]
                ],
            'admin/login' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'login'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action' => 'saveLogin'
                ]
                ],
            'instructions/general'=> [
                'GET' => [
                    'controller' => $homeController,
                    'action' => 'instruccion'
                ]
                ],
            'logout' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'logOut'
                ]
                ],
            'error' => [
                    'GET' => [
                        'controller' => $homeController,
                        'action' => 'error'
                    ]
                    ],
            'error/404' => [
                        'GET' => [
                            'controller' => $homeController,
                            'action' => 'error404'
                        ]
                        ],
            /**----------------------------------------------- Rutas del Adminstrador ---------------------- */
            /**
             * Todas las rutas que el administrador debe manejar
             * 
             */
            'agregar/agentes-municipales' =>[
                'GET' => [
                    'controller' => $agentesController,
                    'action' => 'view'
                ],
                'POST' => [
                    'controller' => $agentesController,
                    'action' => 'saveAgente'
                ],
                'login' => true,
                'permission' => Usuarios::ADMINISTRADOR
            ],
            'list/agentes' =>[
                'GET' => [
                    'controller' => $agentesController,
                    'action' => 'list'
                ],
                'login' => true,
                'permission' => Usuarios::ADMINISTRADOR
            ],
            'baja/agentes' =>[
                'GET' => [
                    'controller' => $agentesController,
                    'action' => 'removeAgente'
                ],
                'POST' => [
                    'controller' => $agentesController,
                    'action' => 'saveRemoveAgente'
                ],
                'login' => true,
                'permission' => Usuarios::ADMINISTRADOR
            ],
            'respaldos/db' =>[
                'GET' => [
                    'controller' => $databseController,
                    'action' => 'view'
                ],
                'POST' => [
                    'controller' => $databseController,
                    'action' => 'generate'
                ],
                'login' => true,
                'permission' => Usuarios::ADMINISTRADOR
            ],
            'list/respaldos/db' =>[
                'GET' => [
                    'controller' => $databseController,
                    'action' => 'list'
                ],
                'login' => true,
                'permission' => Usuarios::ADMINISTRADOR
            ],
            'cambio/imagen' =>[
                'GET' => [
                    'controller' => $aparienciaController,
                    'action' => 'view'
                ],
                'POST' => [
                    'controller' => $aparienciaController,
                    'action' => 'cambioImagen'
                ],
                'login' => true,
                'permission' => Usuarios::ADMINISTRADOR
            ],
            'cambio/clave' =>[
                'GET' => [
                    'controller' => $agentesController,
                    'action' => 'cambioClave'
                ],
                'POST' => [
                    'controller' => $agentesController,
                    'action' => 'saveCambioClave'
                ],
                'login' => true
                
            ],
            /*---------------------------------------Rutas admin - Jefes de Planta---------------------------*/
            'add/personal-planta' =>[
                'GET' => [
                    'controller' => $agentesController,
                    'action' => 'addJefePlanta'
                ],
                'POST' => [
                    'controller' => $agentesController,
                    'action' => 'saveJefePlanta'
                ],
                'login' => true,
                'permission' => Usuarios::ADMINISTRADOR
            ],
            'baja/personal-planta' =>[
                'GET' => [
                    'controller' => $agentesController,
                    'action' => 'bajaJefePlanta'
                ],
                'POST' => [
                    'controller' => $agentesController,
                    'action' => 'saveBajaJefePlanta'
                ],
                'login' => true,
                'permission' => Usuarios::ADMINISTRADOR
            ],
            /**-------------------------------------------Rutas del JEFE de PLANTA----------------------------- */
            /**
             * Todas las rutas del jefe de planta 
             */
            'list/locales-comerciales' =>[
                'GET' => [
                    'controller' => $plantaController,
                    'action' => 'view'
                ],
                'login' => true,
                'permission' => Usuarios::JEFE_PLANTA
            ],
            'descarga/exel' =>[
                'GET' => [
                    'controller' => $plantaController,
                    'action' => 'descargaExel'
                ],
                'login' => true,
                'permission' => Usuarios::JEFE_PLANTA
            ],
            'editar/locales' =>[
                'GET' => [
                    'controller' => $plantaController,
                    'action' => 'edit'
                ],
                'POST' => [
                    'controller' => $plantaController,
                    'action' => 'saveEdit'
                ],
                'login' => true,
                'permission' => Usuarios::JEFE_PLANTA
            ],
             /**---------------------------------------------Rutas de la API-------------------------------- */
             /**
              * Todas las rutas que se van a usar para consultar,insertar,actualizar y borrar con la API
              * Deberan comenzar con api/** 
              */
            'api/agentes-municipales' => [
                'GET' => [
                    'controller' => $apiController,
                    'action' => 'getAgentes'
                ],
                'POST' => [
                    'controller' => $apiController,
                    'action' => 'addAgentes'
                ],
            ],
            'api/locales-comerciales' =>  [
                'GET' => [
                    'controller' => $apiController,
                    'action' => 'getLocales'
                ],
                'POST' => [
                    'controller' => $apiController,
                    'action' => 'addLocales'
                ],
            ],
            'api/locaciones' => [
                'GET' => [
                    'controller' => $apiController,
                    'action' => 'getLocaciones'
                ],
                'POST' => [
                    'controller' => $apiController,
                    'action' => 'addLocacion'
                ],
            ],
            'api/actualizar/agente' => [
                'POST' => [
                    'controller' => $apiController,
                    'action' => 'updateAgente'
                ],
            ],
            'api/prueba' => [
                'GET' => [
                    'controller' => $apiController,
                    'action' => 'pruebaHeaders'
                ],
                'POST' => [
                    'controller' => $apiController,
                    'action' => 'setPruebaHeaders'
                ],
            ],
            
        ];
    }

    public function autentification(): Autentification
    {
        return $this->autentification;
    }
    public function hasPermission($permission): bool
    {
        $user = $this->autentification->getUser();

        return $user->hasPermission($permission);
    }
}