<?php

namespace App\Frame;
/**
 * Esta interface determina los metodos 
 * que deben contemplar todas las rutas
 */
interface Routes{

    public function getRoutes(): array;
    
    public function autentification() : Autentification;

    public function hasPermission($permission): bool;
}