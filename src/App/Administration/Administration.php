<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 6/12/2021
 * Time: 7:55 PM
 */

namespace Absoft\Line\App\Administration;


use Absoft\Line\App\Files\DirConfiguration;
use Absoft\Line\Core\HTTP\Route;

class Administration {

    public static function routes(){

        Route::set("/Admin/all_controllers", "/token");
        Route::set("/Admin/all_models", "/token");
        Route::set("/Admin/all_builders", "/token");

        Route::set("/Admin/new_controller", "/token/name");
        Route::set("/Admin/new_model", "/token/name");
        Route::set("/Admin/new_builder", "/token/name");

        Route::set("/Admin/initiate", "/token/name");

        Route::set("/Admin/delete_builder", "/token/name");
        Route::set("/Admin/delete_model", "/token/name");
        Route::set("/Admin/delete_controller", "/token/name");
        Route::set("/Admin/schema", "/token/name");
        Route::set("/Admin/records", "/token/name");
        Route::set("/Admin/drop", "/token/name");
        Route::set("/Admin/export", "/token/name");
        Route::set("/Admin/insertData", "/token/name/data");

        Route::set("/Admin/login", "/username/password");
        Route::set("/Admin/logout", "/token");
        Route::set("/Admin/change_password", "/token/old_password/new_password/username");
        Route::set("/Admin/login_update", "/token/password");
        Route::set("/Admin/authorization", "/token");
        Route::set("/Admin/view_token", "/token");

        Route::set("/Admin/about", "");
        Route::set("/Admin/info", "/name");

        Route::set("/Admin/variables", "/token");

        // route administrations

        Route::set("/Admin/create_route", "/token/route_name/parameters");
        Route::set("/Admin/delete_route", "/token/route_name");
        Route::set("/Admin/update_route", "/token/route_name/changed");
        Route::set("/Admin/get_routes", "/token/controller");

    }

    /**
     * @return array
     */
    public static function variables(){
        return (array) json_decode(file_get_contents(DirConfiguration::$_main_folder."/apps/Runtime/administration.json"));
    }

    /**
     * @param $name
     * @return bool
     */
    public static function deleteVariable($name){

        $vars = self::variables();

        if(isset($vars[$name])){

            unset($vars[$name]);
            file_put_contents(DirConfiguration::$_main_folder."/apps/Runtime/administration.json", json_encode($vars));

        }

        return true;

    }

    /**
     * @param $name
     * @param $attribute
     * @param $value
     * @return bool
     */
    public static function changeVariable($name, $attribute, $value){

        $vars = self::variables();
        $object = isset($vars[$name]) ? (array) $vars[$name] : [];

        $object[$attribute] = $value;
        $vars[$name] = $object;
        file_put_contents(DirConfiguration::$_main_folder."/apps/Runtime/administration.json", json_encode($vars));
        return true;

    }

    /**
     * @param $name
     * @param $exported
     * @param $initiated
     * @param $model
     * @param $builder
     * @param $controller
     * @param $initializer
     * @return bool
     */
    public static function createVariable($name, $exported, $initiated, $model, $builder, $controller, $initializer){

        $vars = self::variables();

        if(isset($vars[$name])){
            return false;
        }

        $object = [];

        $object["exported"] = $exported;
        $object["initiated"] = $initiated;
        $object["model"] = $model;
        $object["builder"] = $builder;
        $object["controller"] = $controller;
        $object["initializer"] = $initializer;

        $vars[$name] = $object;

        file_put_contents(DirConfiguration::$_main_folder."/apps/Runtime/administration.json", json_encode($vars));

        return true;

    }

    /**
     * @param $name
     * @return array
     s*/
    public static function see($name){

//        $mdb = new Builders();
//        $mdc = new Controllers();
//        $mdi = new Initializers();
//        $mdm = new Models();
//
//        $builders = $mdb->all();
//        $controllers = $mdc->all();
//        $initializers = $mdi->all();
//        $models = $mdm->all();

        $vars = self::variables();

        return $name == "all" ? $vars : (isset($vars[$name]) ? (array) $vars[$name] : []);

    }

//    public static function


}
