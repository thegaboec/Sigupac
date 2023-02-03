<?php

namespace App\Models;

use App\Models\Conection\ConectionDB;

class DatabaseTable extends ConectionDB{
    protected $table;
    private $primaryKey;
    private $className;
    private $arguments;

    public function __construct(
        string $table,
        string $primaryKey,
        $className = '\stdClass',
        array $arguments = []
    )
    {
        parent::__construct();
        $this->table = $table;
        $this->primaryKey= $primaryKey;
        $this->className= $className;
        $this->arguments= $arguments;
    }
    
    protected function runQuery($query, $params =[]){
        $result = $this->prepare($query);
        $result->execute($params);
        return $result;
    }
    
    private function inserDate($params)
    {
        foreach ($params as $key => $value) {
            if ($key instanceof \DateTime) {
                $params[$key] = $value->format('Y-m-d H:i:s');
            }
        }

        return $params;
    }

    public function insert($params): void
    {
        $params = $this->inserDate($params);

        $query = 'INSERT INTO ' . $this->table . ' (';

        foreach ($params as $key => $value) {
            $query .= '' . $key . ' ,';
        }

        $query = rtrim($query, ',');

        $query .= ') VALUES (';
        foreach ($params as $key => $value) {
            $query .= ':' . $key . ',';
        }

        $query = rtrim($query, ',');

        $query .= ')';

       $this->runQuery($query,$params);
    }

    public function selectFromColumn($column, $restrict)
    {

        $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . '= :' . $this->primaryKey;
        $params = [$this->primaryKey => $restrict];
        $result = $this->runQuery($query, $params);
        return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->arguments);
    }
    public function select($limit = null, $offset = null, $orderBy = false, $column = null)
    {
        $query = 'SELECT * FROM ' . $this->table . ' ';

        if ($orderBy == true && $column != null) {
            $query .= ' ORDER BY ' . $column . ' ASC ';
        }

        if ($limit != null) {
            $query .= 'LIMIT ' . $limit;
        }

        if ($offset != null) {
            $query .= ' OFFSET ' . $offset;
        }

        $result = $this->runQuery($query);
        return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->arguments);
    }
    public function selectArray($limit = null, $offset = null, $orderBy = false, $column = null)
    {
        $query = 'SELECT * FROM ' . $this->table . ' ';

        if ($orderBy == true && $column != null) {
            $query .= ' ORDER BY ' . $column . ' ASC ';
        }

        if ($limit != null) {
            $query .= 'LIMIT ' . $limit;
        }

        if ($offset != null) {
            $query .= ' OFFSET ' . $offset;
        }

        $result = $this->runQuery($query);
       // var_dump($this->className);
        return $result->fetchAll();
    }
    public function update($params)
    {
        $params = $this->inserDate($params);
        $query = 'UPDATE ' . $this->table . ' SET ';
        foreach ($params as $key => $value) {
            $query .= '' . $key . '=:' . $key . ',';
        }

        $query = rtrim($query, ',');

        $query .= ' WHERE ' . $this->primaryKey . ' = :' . $this->primaryKey;
        $this->runQuery($query, $params);
    }

    public function lastInsert($column){
        $last = $this->lastInsertId();
        echo $last;
       // return $this->selectFromColumn($column,$last);
    }

    public function insertUltimate($params){
        $className = new $this->className(...$this->arguments);
        $this->insert($params);
        $id = $this->lastInsertId();
        $className->{$this->primaryKey} = $id;
        foreach($params as $key => $propietes){
            if (!empty($propietes)){
                $className->$key = $propietes;
            }
            
        }
        return $className;
    }
}
