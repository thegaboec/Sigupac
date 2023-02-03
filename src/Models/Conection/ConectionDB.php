<?php

namespace App\Models\Conection;

class ConectionDB extends \PDO{

    private $HOST;
    private $DB_NAME;
    private $USER;
    private $PASS;

    public function __construct()
    {
        $this->HOST = $_ENV['HOST'];
        $this->DB_NAME =  $_ENV['DBNAME'];
        $this->USER = $_ENV['USER'];
        $this->PASS = $_ENV['PASSWORD'];

        parent::__construct('mysql:host=' . $this->HOST . ';port=3306;setchar=utf8;dbname=' . $this->DB_NAME, $this->USER,$this->PASS);
        $this->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
    }


}