<?php

function makeTree(string $address, $value){
    
    $array = explode("/", $address);
    $tree = [
        "root" => []
    ];

    $tempTree = [];
    foreach($array as $word){
        if(is_string($word) && $word[0] != ":"){

            if(!isset($tree[$word])){

            }

        }else if(is_string($word) && $word[0] == ":"){

        }
    }

}

class Node {
    
    public $address;
    public $children = [];
    public $values;

    function __construct($address = "", $values = []){
        
        $this->address = $address;
        $this->values = $values;

    }

    function addChild(array $names, $method){

        if(sizeof($names) > 0){

            return $this->searchAndSet($names, $this, $method);

        }else{
            $this->values = [
                "params" => [],
                "method" => $method
            ];
        }

    }

    private function searchAndSet(array $names, Node $tree, $method, $index = 0){

        if(!isset($names[$index])){

            $tree->values = [
                "params" => [],
                "method" => $method
            ];

            return $tree;

        }

        if($index == 0 && empty($names[$index])){

            $result = self::searchAndSet($names, $tree, $method, $index + 1);
            if(!$result){
                return null;
            }

            $tree->children[$names[$index]] = $result;
            return $tree;

        }

        if(strpos($names[$index], ":") > -1){
            $tree->values = [
                "params" => array_slice($names, $index),
                "method" => $method
            ];
            return $tree;
        }

        if(sizeof($tree->children) == 0){
            $temp = null;
            foreach(array_slice($names, $index) as $name){
                if($temp){
                    $temp = "";
                }
            }
            return ["node" => $tree, "index" => $index];
        }

        if(isset($tree->children[$names[$index]])){
            return self::searchAndSet($names, $tree->children[$names[$index]], $method, $index + 1);
        }else{
            return empty($names[$index]) ? [] : ["node" => $tree, "index" => $index];
        }

    }

    static function search(array $names, Node $tree, $index = 0){

        if(!isset($names[$index])){
            return $index > 0 ? $tree : null;
        }

        if(sizeof($tree->children) == 0){
            return $tree;
        }

        if(isset($tree->children[$names[$index]])){
            return self::search($names, $tree->children[$names[$index]], $index + 1);
        }else{
            return $index ? $tree : null;
        }

    }

}