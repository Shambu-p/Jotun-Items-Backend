<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 10/26/2019
 * Time: 8:52 AM
 */

namespace Absoft\Line\Core\Modeling;

use Absoft\Line\App\API\Response;
use Absoft\Line\App\Files\DirConfiguration;
use Absoft\Line\Core\Engines\HTTP\Engine;
use Absoft\Line\Core\FaultHandling\Exceptions\RouteNotFound;
use Absoft\Line\Core\HTTP\FileResponse;
use Absoft\Line\Core\HTTP\JSONResponse;
use Absoft\Line\Core\HTTP\Request;
use Absoft\Line\Core\HTTP\ViewResponse;

abstract class Controller{

    public $_main_address;

    /** @var Request */
    public $request;
    public static $J = 1;
    public static $H = 2;

    public function __construct(){

        $this->request = Engine::$request;
        $this->_main_address = DirConfiguration::$_main_folder;

    }

    /**
     * @param $name
     * @param $parameter
     * @throws RouteNotFound
     * @return mixed
     */
//    abstract public function route($name, $parameter);

    /**
     * @param $response
     * @param int $flag
     * @return Request
     */
    public function respond($response, $flag = 2){

        if($flag == 1){

            $resp = new Response($response);
            return $resp->respond();

        }else{

            header("Provider: Absoft");
            header("Access-Control-Allow-Origin: *");

            $return = new Request();
            $return->link = Request::hostAddress().$_SERVER["REQUEST_URI"];
            print $response;
            return $return;
        }

    }

    /**
     * @param $file
     * @param bool $download
     * @return FileResponse
     */
    public function respondFile($file, $download = false){

        $response = new FileResponse();
        $response->prepare($file, $download);
        return $response;

    }

    public function json($array){
        $response = new JSONResponse();
        $response->prepareData($array);
        return $response;
    }

    public function display($location, $request_data){
        $response = new ViewResponse();
        $response->prepare(DirConfiguration::$_main_folder."/apps/Templates".$location.".php", $request_data);
        return $response;
    }

    public function fileResponse($name, $size, $extension, $content, $download = false){

        if($download){
            return Response::fileDownload([
                "content" => $content,
                "name" => $name,
                "size" => $size,
                "extension" => $extension
            ]);
        }

        return Response::fileContent([
            "content" => $content,
            "name" => $name,
            "size" => $size,
            "extension" => $extension
        ]);

    }

}
