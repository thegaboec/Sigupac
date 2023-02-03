<?php

namespace App\Models;

class Locales extends DatabaseTable {
    public $id;
    public $nombre;
    public $tipo;
    public $imagen;
    public $id_locacion;
    public $id_propietario;
    public $id_usuario;
    public $contabilidad;
    private $modelPropietarios;

    public function __construct(
    )
    {
        parent::__construct('locales','id','\App\Models\Locales',[
            'locales',
            'id'
        ]);
       
    }

    public function getAllInformation(){
         $this->modelPropietarios= new Propietarios;
        $final = [];
        $locales = $this->select();
        foreach($locales as $local){
            $indexes = $this->modelPropietarios->selectFromColumn('id',$local->id_propietario);
            if($indexes){
                $local_propietario = new Locales_Propietario();
                $local_propietario->id_local = $local->id;
                $local_propietario->nombre_local = $local->nombre;
                $local_propietario->tipo = $local->tipo;
                $local_propietario->imagen = $local->imagen;
                $local_propietario->contabilidad = $local->contabilidad;
                $local_propietario->id = $indexes[0]->id;
                $local_propietario->nombre_propietario = $indexes[0]->nombre;
                $local_propietario->cedula = $indexes[0]->cedula;
                $local_propietario->ruc = $indexes[0]->ruc;
                $local_propietario->anonimo = $indexes[0]->anonimo;
                $local_propietario->celular = $indexes[0]->celular;

                array_push($final,$local_propietario);
            }

        }
        
       return $final;
    }

    public function selectLocal($option,$value){
        $this->modelPropietarios= new Propietarios;
        $locales = [];
        $propietario = $this->modelPropietarios->selectFromColumn($option,$value);
        if($propietario){
                $localesIn = $this->selectFromColumn('id_propietario',$propietario[0]->id);
                if($localesIn){
                    foreach($localesIn as $local){
                        $local_propietario = new Locales_Propietario();
                        $local_propietario->id_local = $local->id;
                        $local_propietario->nombre_local = $local->nombre;
                        $local_propietario->tipo = $local->tipo;
                        $local_propietario->imagen = $local->imagen;
                         $local_propietario->contabilidad = $local->contabilidad;
                        $local_propietario->id = $propietario[0]->id;
                        $local_propietario->nombre_propietario = $propietario[0]->nombre;
                        $local_propietario->cedula = $propietario[0]->cedula;
                        $local_propietario->ruc = $propietario[0]->ruc;
                        $local_propietario->anonimo = $propietario[0]->anonimo;
                        $local_propietario->celular = $propietario[0]->celular;

                        array_push($locales,$local_propietario);
                    }
                }
        }

        return $locales;
    }

    public function getLocalInformation($id){
        $this->modelPropietarios= new Propietarios;
        $result = null;
        $local = $this->selectFromColumn('id',$id);
        if($local){
            $local = $local[0];
            $propietario = $this->modelPropietarios->selectFromColumn('id',$local->id_propietario);
            $local_propietario = new Locales_Propietario();
                        $local_propietario->id_local = $local->id;
                        $local_propietario->nombre_local = $local->nombre;
                        $local_propietario->tipo = $local->tipo;
                        $local_propietario->imagen = $local->imagen;
                        $local_propietario->contabilidad = $local->contabilidad;

                        $local_propietario->id = $propietario[0]->id;
                        $local_propietario->nombre_propietario = $propietario[0]->nombre;
                        $local_propietario->cedula = $propietario[0]->cedula;
                        $local_propietario->ruc = $propietario[0]->ruc;
                        $local_propietario->anonimo = $propietario[0]->anonimo;
                        $local_propietario->celular = $propietario[0]->celular;

                        $result = $local_propietario;
        }
        return $result;
    }
    
    
      public function getLocalContabilidad($option){
        $this->modelPropietarios= new Propietarios;
        $result = null;
        $local = $this->selectFromColumn('contabilidad',$option);
        if($local){
            $local = $local[0];
            $propietario = $this->modelPropietarios->selectFromColumn('id',$local->id_propietario);
            $local_propietario = new Locales_Propietario();
                        $local_propietario->id_local = $local->id;
                        $local_propietario->nombre_local = $local->nombre;
                        $local_propietario->tipo = $local->tipo;
                        $local_propietario->imagen = $local->imagen;
                        $local_propietario->contabilidad = $local->contabilidad;

                        $local_propietario->id = $propietario[0]->id;
                        $local_propietario->nombre_propietario = $propietario[0]->nombre;
                        $local_propietario->cedula = $propietario[0]->cedula;
                        $local_propietario->ruc = $propietario[0]->ruc;
                        $local_propietario->anonimo = $propietario[0]->anonimo;
                        $local_propietario->celular = $propietario[0]->celular;

                        $result = $local_propietario;
        }
        return $result;
    }
    public function getAllLocalsContabilidad($option = null, $query = null)
    {
        $this->modelPropietarios= new Propietarios;
        if($option !== null && $query !== null){
        $final = [];
        $locales = $this->selectFromColumn($option, $query);
        foreach($locales as $local){
            $indexes = $this->modelPropietarios->selectFromColumn('id',$local->id_propietario);
            if($indexes){
                $local_propietario = new Locales_Propietario();
                $local_propietario->id_local = $local->id;
                $local_propietario->nombre_local = $local->nombre;
                $local_propietario->tipo = $local->tipo;
                $local_propietario->imagen = $local->imagen;
                $local_propietario->contabilidad = $local->contabilidad;
                $local_propietario->id = $indexes[0]->id;
                $local_propietario->nombre_propietario = $indexes[0]->nombre;
                $local_propietario->cedula = $indexes[0]->cedula;
                $local_propietario->ruc = $indexes[0]->ruc;
                $local_propietario->anonimo = $indexes[0]->anonimo;
                $local_propietario->celular = $indexes[0]->celular;

                array_push($final,$local_propietario);
            }

        }
        }
       return $final;
    }
}
