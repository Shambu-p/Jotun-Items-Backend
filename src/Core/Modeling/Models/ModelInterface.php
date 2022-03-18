<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 2/28/2021
 * Time: 12:49 PM
 */

namespace Absoft\Line\Core\Modeling\Models;


interface ModelInterface {

    /**
     * @param $key
     * @return array
     */
    public function findRecord($key);

    /**
     * @return mixed
     */
    function getEntity();

    public function searchRecord();

    public function deleteRecord();

    public function updateRecord();

    public function addRecord();

    /**
     * @param array $search_array
     * @param array $limit
     * @return mixed
     *
     * [
            "name" => "",
            "email" => "dma"
            ":post" => [
                ":on" => "poster",
                "text" => "",
                "date" => ""
            ]
       ]
     */
    public function advancedSearch(Array $search_array, $limit = []);

}
