<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 2/9/2020
 * Time: 4:52 PM
 */

namespace Absoft\Line\App\Files;

class Loader
{

    /**
     * @param $js_name
     * @return false|string
     */
    public static function jsAddress($js_name){

        if(file_exists(DirConfiguration::$_main_folder.DirConfiguration::$dir["js"]."/$js_name")){
            return file_get_contents(DirConfiguration::$_main_folder.DirConfiguration::$dir["js"]."/$js_name");
        }
        else{
            return "js not found";
            //throw new FileNotFound(DirConfiguration::$_main_folder.DirConfiguration::$dir["js"]."/$js_name", __FILE__, __LINE__);
        }

    }

    /**
     * @param $css_name
     * @return false|string
     */
    public static function cssAddress($css_name){

        if(file_exists(DirConfiguration::$_main_folder.DirConfiguration::$dir["css"]."/$css_name")){
            return file_get_contents(DirConfiguration::$_main_folder.DirConfiguration::$dir["css"]."/$css_name");
        }
        else{
            return "not found";
            //throw new FileNotFound(DirConfiguration::$_main_folder.DirConfiguration::$dir["css"]."/$css_name", __FILE__, __LINE__);
        }

    }

}
