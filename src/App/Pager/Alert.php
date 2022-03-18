<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 6/20/2020
 * Time: 11:47 AM
 */

namespace Absoft\Line\App\Pager;

use Application\conf\Configuration;

class Alert {

    public static function sendSuccessAlert($message){
        $_SESSION["_system"]["alert"]["success"]["message"] = $message;
    }

    public static function sendInfoAlert($message){
        $_SESSION["_system"]["alert"]["info"]["message"] = $message;
    }

    public static function sendErrorAlert($message){
        $_SESSION["_system"]["alert"]["error"]["message"] = $message;
    }

    public static function displayAlert(){

        if(isset($_SESSION["_system"]["alert"]["success"]["message"]) && $_SESSION["_system"]["alert"]["success"]["message"] != ""){

            print '
            
            <div class="'.self::getSuccessClassName().'">
            
            '.$_SESSION["_system"]["alert"]["success"]["message"].'
            
            </div>
            
            ';

            $_SESSION["_system"]["alert"]["success"]["message"] = "";

        }

        if(isset($_SESSION["_system"]["alert"]["info"]["message"]) && $_SESSION["_system"]["alert"]["info"]["message"] != ""){

            print '
            
            <div class="'.self::getInfoClassName().'">
            
            '.$_SESSION["_system"]["alert"]["info"]["message"].'
            
            </div>
            
            ';

            $_SESSION["_system"]["alert"]["info"]["message"] = "";

        }

        if(isset($_SESSION["_system"]["alert"]["error"]["message"]) && $_SESSION["_system"]["alert"]["error"]["message"] != ""){

            print '
            
            <div class="'.self::getErrorClassName().'">
            
            '.$_SESSION["_system"]["alert"]["error"]["message"].'
            
            </div>
            
            ';

            $_SESSION["_system"]["alert"]["error"]["message"] = "";

        }

    }

    public static function setSuccessClassName($name){
        $_SESSION["_system"]["alert"]["success"]["class_name"] = $name;
    }

    public static function setErrorClassName($name){
        $_SESSION["_system"]["alert"]["error"]["class_name"] = $name;
    }

    public static function setInfoClassName($name){
        $_SESSION["_system"]["alert"]["info"]["class_name"] = $name;
    }

    public static function getSuccessClassName(){

        if($_SESSION["_system"]["alert"]["success"]["class_name"] == ""){
            $_SESSION["_system"]["alert"]["success"]["class_name"] = Configuration::$admin_conf["success_class_name"];
        }

        return $_SESSION["_system"]["alert"]["success"]["class_name"];

    }

    public static function getErrorClassName(){

        if($_SESSION["_system"]["alert"]["error"]["class_name"] == ""){
            $_SESSION["_system"]["alert"]["error"]["class_name"] = Configuration::$admin_conf["error_class_name"];
        }

        return $_SESSION["_system"]["alert"]["error"]["class_name"];

    }

    public static function getInfoClassName(){

        if($_SESSION["_system"]["alert"]["info"]["class_name"] == ""){
            $_SESSION["_system"]["alert"]["info"]["class_name"] = Configuration::$admin_conf["info_class_name"];
        }

        return $_SESSION["_system"]["alert"]["info"]["class_name"];

    }

}
