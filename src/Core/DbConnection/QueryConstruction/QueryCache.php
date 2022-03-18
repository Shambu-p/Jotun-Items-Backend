<?php


namespace Absoft\Line\Core\DbConnection\QueryConstruction;


use Absoft\Line\App\Files\DirConfiguration;

class QueryCache {

    public static function getCached($name){

        $object_mode = (array) json_decode(file_get_contents(DirConfiguration::$_main_folder."/apps/Runtime/query_caches.json"));
        $query_caches = (array) $object_mode["query_cache"];
        $model_caches = (array) $object_mode["model_cache"];

        if(isset($query_caches[$name]) && isset($model_caches[$name])){
            return [
                "query" => $query_caches[$name],
                "model" => $model_caches[$name]
            ];
        }

        return null;

    }

    public static function setCachedModel($name, $from_query, $from_model){

        $object_mode = (array) json_decode(file_get_contents(DirConfiguration::$_main_folder."/apps/Runtime/query_caches.json"));
        $query_caches = (array) $object_mode["query_cache"];
        $model_caches = (array) $object_mode["model_cache"];

        $query_caches[$name] = $from_query;
        $model_caches[$name] = $from_model;

        $object_mode["query_cache"] = $query_caches;
        $object_mode["model_cache"] = $model_caches;
        file_put_contents(DirConfiguration::$_main_folder."/apps/Runtime/query_caches.json", json_encode($object_mode));

    }

    /**
     * @param $name
     * @param $array
     * @param $type
     * @return Query
     */
    public static function getQuery($name, $array, $type){

        $cache = self::getCached($name);

        if(!$cache){
            return null;
        }

        $query_cache = $cache["query"];
        $model_cache = $cache["model"];

        $query = $query_cache["query"];
        $values = [];

        foreach ($model_cache["in_string"] as $key => $value){
            $query = str_replace($key, $value, $query);
        }

        if($type == "condition"){

            foreach ($query_cache["values"] as $ky => $vl){
                $values[$ky] = $array[$model_cache["params"][$vl]]["value"];
            }
            return new Cache($query, $values);

        }else if($type == "join"){

            foreach ($query_cache["values"] as $ky => $vl){

                $values[$ky] = $array;
                $exp = explode("|", $array[$model_cache["params"][$vl]]);

                foreach ($exp as $keys){
                    $values[$ky] =  $values[$ky][$keys];
                }

            }
            return new Cache($query, $values);

        }else if($type == "single_insertion"){

            foreach ($query_cache["values"] as $ky => $vl){
                $values[$ky] = $array[$model_cache["params"][$vl]];
            }
            return new Cache($query, $values);

        }else if( $type == "multiple_insertion"){

            foreach ($query_cache["values"] as $ky => $vl){
                $values[$ky] = $array[$model_cache["params"][$vl][0]][$model_cache["params"][$vl][1]];
            }

            return new Cache($query, $values);

        }else{
            return null;
        }

    }

}