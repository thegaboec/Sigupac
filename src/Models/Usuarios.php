<?php

namespace App\Models;

class Usuarios extends DatabaseTable{
    public $id;
    public $nombre;
    public $clave;
    public $permisos;
    public $estado;
    public $fecha;
    public $celular;
    public const AGENTE_MUNICIPAL = 1;
    public const JEFE_PLANTA = 4;
    public const ADMINISTRADOR = 8;

    public function __construct()
    {
        parent::__construct('usuarios','id','\App\Models\Usuarios',[
            'usuarios',
            'id'
        ]);
    }

    public function getAllAgentes(){
        return $this->selectFromColumn('permisos',self::AGENTE_MUNICIPAL); // Regresa solo los agentes municipales
    }

    public function getAllAgentesActivate(){
        //return $this->selectFromColumn('permisos',self::AGENTE_MUNICIPAL); 
        $query = 'SELECT * FROM usuarios WHERE permisos = '. self::AGENTE_MUNICIPAL. ' AND estado = "activo"';// Regresa solo los agentes municipales activos 
        $result = $this->runQuery($query);

        return $result->fetchAll(\PDO::FETCH_CLASS,'\App\Models\Usuarios',['usuarios','id']);
    }

    public function hasPermission($permission){

        return $this->permisos & $permission;
    }
}