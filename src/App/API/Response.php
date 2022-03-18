<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 4/25/2021
 * Time: 10:55 PM
 */

namespace Absoft\Line\App\API;


use Absoft\Line\Core\FaultHandling\FaultHandler;
use Absoft\Line\Core\HTTP\Request;

class Response {

    private $response = [
        "header" => [
            "error" => "false",
            "message" => ""
        ],
        "data" => []
    ];

    public static $extensions = [
        "images" => ["png", "jpg", "jpeg", "ico", "svg", "gif"],
    ];


    function __construct($array){

        if(FaultHandler::checkError()){
            $this->response["header"]["error"] = "true";
            $this->response["header"]["message"] = FaultHandler::getError()["description"];
        }
        else{
            $this->response["data"] = $array;
        }

        FaultHandler::clearError();

    }

    /**
     * @return Request
     */
    function respond(){

        header("Provider: Absoft");
        header("Access-Control-Allow-Origin: *");
        header("Content-type: application/json");

        print json_encode($this->response);
        return $this->prepare();

    }


    /**
     * @param $file
     * @return Request
     */
    static function fileContent($file){

        header("Provider: Absoft");
        header("Access-Control-Allow-Origin: *");

        $return = new Request();
        $return->link = Request::hostAddress().$_SERVER["REQUEST_URI"];

        if(is_array($file)){

            if(in_array(strtolower($file["extension"]), self::$extensions["images"])){
                header("Content-type: image/".$file["extension"]);
            }else {
                header("Content-type: application/".$file["extension"]);
            }
            header('Content-Length: ' . $file["size"]);
            print $file["content"];

        }else{

            if(file_exists($file)){

                $file_name = basename($file);
                $arr = explode(".", $file_name);
                $extension = (sizeof($arr) > 1) ? $arr[sizeof($arr) - 1] : "";
                if(in_array(strtolower($extension), self::$extensions["images"])){
                    header("Content-type: image/".$extension);
                }else {
                    header("Content-type: application/".$extension);
                }

                header('Content-Length: ' . filesize($file));
                print file_get_contents($file);

            }

        }

        return $return;

    }

    /**
     * @param $file
     * @return Request
     */
    static function fileDownload($file){

        $return = new Request();
        $return->link = Request::hostAddress().$_SERVER["REQUEST_URI"];

        header("Provider: Absoft");
        header("Access-Control-Allow-Origin: *");

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        if(is_array($file)){

            header('Content-Disposition: attachment; filename="'.$file["name"].'"');
            header('Content-Length: ' . $file["size"]);
            flush(); // Flush system output buffer
            print $file["content"];

        }else{

            if(file_exists($file)){

                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Content-Length: ' . filesize($file));
                flush(); // Flush system output buffer
                readfile($file);

            }

        }

        return $return;

    }

    /**
     * @return Request
     */
    private function prepare(){

        $return = new Request();

        $return->request = (object) $this->response;
        $return->link = Request::hostAddress().$_SERVER["REQUEST_URI"];
        return $return;

    }

}
