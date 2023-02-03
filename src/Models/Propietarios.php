<?php

namespace App\Models;

class Propietarios extends DatabaseTable{
    public $id;
    public $cedula;
    public $nombre;
    public $ruc;
    public $anonimo;
    public $celular;

    public function __construct()
    {
        parent::__construct('propietarios','id','\App\Models\Propietarios',[
            'propietarios',
            'id'
        ]);
    }

    public function insertLast($params): Propietarios
    {
        $model = new Propietarios();
        $this->insert($params);
        $model->id = $this->lastInsertId();

        foreach($params as $key => $value){
            $model->$key = $value;
        }

        return $model;
    }
}