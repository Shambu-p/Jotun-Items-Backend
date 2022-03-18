<?php


namespace Absoft\Line\Core\DbConnection\QueryConstruction;


class Cache implements Query {

    private $query = "";
    private $values = [];

    function __construct($query_string, $values){
        $this->query = $query_string;
        $this->values = $values;
    }

    function getQuery(){return $this->query;}

    function getValues(){return $this->values;}

}