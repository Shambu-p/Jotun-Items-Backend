<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 3/1/2021
 * Time: 9:40 AM
 */
namespace Absoft\Line\App\Security;

use Absoft\Line\Core\Modeling\Models\Model;
use Application\conf\AuthConfiguration;
use Application\Models\UsersModel;

class Auth {

    public static function grant($user){

        $model_name = "Application\\Models\\".AuthConfiguration::$conf["user_auth"]["table"]."Model";

        /** @var Model $user_model */
        $user_model = new $model_name;
        $_SESSION["auth"]["login"] = "true";

        foreach ($user_model->MAINS as $main => $value){

            if(isset($user[$main])){
                $_SESSION["auth"][$main] = $user[$main];
            }

        }

    }

    public static function user(){

        if(isset($_SESSION["auth"]) && sizeof($_SESSION["auth"]) > 0){
            return (object) $_SESSION["auth"];
        }

        return null;

    }

    public static function deni(){
        unset($_SESSION["auth"]);
    }

    public static function checkLogin(){

        if(isset($_SESSION["auth"][""]) && $_SESSION["auth"]["login"] == "true"){
            return true;
        }

        return false;

    }

    public static function checkUser($key, $value){

        if(self::checkLogin() && self::user()->$key == $value){
            return true;
        }

        return false;

    }

    public static function Authenticate($auth_name, array $parameters){

        $p_size = sizeof($parameters);
        $w_size = sizeof(AuthConfiguration::$conf[$auth_name]["with"]);

        if($p_size != $w_size && $p_size > 0 && $w_size > 0){
            return [];
        }

        $model_name = $auth_name == "admin_auth" ? "Absoft\\App\\Administration\\".AuthConfiguration::$conf[$auth_name]["table"]."Model" : "Application\\Models\\".AuthConfiguration::$conf[$auth_name]["table"]."Model";

        /** @var Model $model */
        $model = new $model_name;

        if(!in_array(AuthConfiguration::$conf[$auth_name]["with"][0], $model->MAINS) && !in_array(AuthConfiguration::$conf[$auth_name]["with"][0], $model->HIDDEN)){
            return [];
        }

        if(isset(AuthConfiguration::$conf[$auth_name]["with"][1]) && !in_array(AuthConfiguration::$conf[$auth_name]["with"][1], $model->MAINS) && !in_array(AuthConfiguration::$conf[$auth_name]["with"][0], $model->HIDDEN)){
            return [];
        }

        if(sizeof(AuthConfiguration::$conf[$auth_name]["with"]) && AuthConfiguration::$conf[$auth_name]["order"] == "keep"){

            $qr = $model->searchRecord();
            $qr->where(AuthConfiguration::$conf[$auth_name]["with"][0], $parameters[0]);

            $result = $qr->fetch();

            if(isset(AuthConfiguration::$conf[$auth_name]["with"][1])){

                if(isset($model->HIDDEN[AuthConfiguration::$conf[$auth_name]["with"][1]])){

                    foreach($result as $res){

                        if(password_verify($parameters[1], $res[AuthConfiguration::$conf[$auth_name]["with"][1]])){
                            //$token = AuthorizationManagement::set($res, "user_auth");
                            return $res;
                        }

                    }

                }
                else if(isset($model->MAINS[AuthConfiguration::$conf[$auth_name]["with"][1]])){
                    foreach($result as $res){

                        if(password_verify($parameters[1], $res[AuthConfiguration::$conf[$auth_name]["with"][1]])){
                            //$token = AuthorizationManagement::set($res, "user_auth");
                            return $res;
                        }

                    }
                }

            }

        }
        else if(sizeof(AuthConfiguration::$conf[$auth_name]["with"]) && isset(AuthConfiguration::$conf[$auth_name]["order"]) && AuthConfiguration::$conf[$auth_name]["order"] == "once"){

            $count = 0;
            $qr = $model->searchRecord();

            foreach(AuthConfiguration::$conf[$auth_name]["with"] as $with){

                $qr->where($with, $parameters[$count]);
                $count += 1;

            }

            //$token = AuthorizationManagement::set($res, "user_auth");
            return $qr->fetch();

        }

        return [];

    }

}
