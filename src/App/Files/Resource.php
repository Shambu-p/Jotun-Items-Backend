<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 10/31/2020
 * Time: 1:12 PM
 */

namespace Absoft\Line\App\Files;


use Absoft\Line\Core\FaultHandling\Exceptions\FileNotFound;

class Resource
{

    public static function imageAddress($image_name){

        $type = pathinfo($image_name)["extension"];
        if(Resource::checkFile(DirConfiguration::$dir["resources"]."/images/$image_name")){

            //$handle = @fopen($_SESSION["_system"]["_main_url"]."resource/images/$image_name", "rb");
            $content = file_get_contents(DirConfiguration::$_main_folder.DirConfiguration::$dir["resources"]."/images/$image_name");
            $content = base64_encode($content);

            return "data:image/$type;base64,".''.$content.'';

        }else{
            return "not found";
            //throw new FileNotFound(DirConfiguration::$dir["resources"]."/images/$image_name", __FILE__, __LINE__);
        }

    }

    public static function loadAudio($address){

        $type = pathinfo($address)["extension"];
        if(Resource::checkFile(DirConfiguration::$dir["resources"]."/audio/$address")){

            //$handle = @fopen(DirConfiguration::$_main_folder.DirConfiguration::$dir["resources"]."/audio/$address", "rb");
            $content = file_get_contents(DirConfiguration::$_main_folder.DirConfiguration::$dir["resources"]."/audio/$address");
            $content = base64_encode($content);

            return "data:audio/$type;base64,".''.$content.'';

        }else{
            return "not found";
            //throw new FileNotFound(DirConfiguration::$dir["resources"]."/audio/$address", __FILE__, __LINE__);
        }

    }

    public static function loadVideo($address){

        $type = pathinfo($address)["extension"];
        if(Resource::checkFile(DirConfiguration::$_main_folder.DirConfiguration::$dir["resources"]."/videos/$address")){

            $handle = @fopen(DirConfiguration::$_main_folder.DirConfiguration::$dir["resources"]."/videos/$address", "rb");
            $content = file_get_contents(DirConfiguration::$_main_folder.DirConfiguration::$dir["resources"]."/videos/$address");
            $content = base64_encode($content);

            return "data:video/$type;base64,".''.$content.'';

        }else{
            return "not found";
            //throw new FileNotFound(DirConfiguration::$_main_folder.DirConfiguration::$dir["resources"]."/videos/$address", __FILE__, __LINE__);
        }

    }

    /**
     * @param $address
     * @return string
     */
    public static function loadDocuments($address){

        $type = pathinfo($address)["extension"];
        if(Resource::checkFile(DirConfiguration::$dir["resources"]."/documents/$address")){

            $content = file_get_contents(DirConfiguration::$_main_folder.DirConfiguration::$dir["resources"]."/documents/$address");
            $content = base64_encode($content);
            return "data:application/$type;base64,".''.$content.'';

        }else{
            return "not found";
            //throw new FileNotFound(DirConfiguration::$dir["resources"]."/documents/$address", __FILE__, __LINE__);
        }

    }

    public static function loadResource($address){

        if(Resource::checkFile(DirConfiguration::$dir["resources"]."/$address")){
            $type = pathinfo($address)["extension"];
            $content = file_get_contents(DirConfiguration::$_main_folder.DirConfiguration::$dir["resources"]."/$address");
            $content = base64_encode($content);
            return "data:application/$type;base64,".''.$content.'';
        }else{
            return "not found";
            //throw new FileNotFound(DirConfiguration::$dir["resources"]."/$address", __FILE__, __LINE__);
        }

    }

    public static function checkFile($address){

        if(file_exists(DirConfiguration::$_main_folder.$address)){
            return true;
        }

        return false;

    }

}
