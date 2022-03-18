<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 2/27/2021
 * Time: 5:59 PM
 */

namespace Absoft\Line\Core\Engines\HTTP;

use Absoft\Line\Core\FaultHandling\Exceptions\ControllerNotFound;
use Absoft\Line\App\Files\DirConfiguration;
use Absoft\Line\Core\FaultHandling\Exceptions\ErrorUnknown;
use Absoft\Line\Core\FaultHandling\Exceptions\FileNotFound;
use Absoft\Line\Core\FaultHandling\Exceptions\LineException;
use Absoft\Line\Core\FaultHandling\Exceptions\RouteNotFound;
use Absoft\Line\Core\FaultHandling\FaultHandler;
use Absoft\Line\Core\HTTP\Decode\RequestAnalyzer;
use Absoft\Line\Core\HTTP\JSONResponse;
use Absoft\Line\Core\HTTP\Request;
use Absoft\Line\Core\HTTP\Response;
use Absoft\Line\Core\HTTP\Route;
use Absoft\Line\Core\HTTP\ViewResponse;

class Engine {

    /**
     * @var Request
     * this field will hold the request sent to the server.
     */
    public static $request;
    private $main_folder;

    /**
     * Engine constructor.
     * @param $location string
     */
    function __construct(string $location){

        try{

            FaultHandler::fromBrowser();
            $this->main_folder = $location;
            $decoder = new RequestAnalyzer();

            self::$request = $decoder->getRequest();
            DirConfiguration::$_main_folder = $location;

        }catch (LineException $exception){
            DirConfiguration::$_main_folder = $location;
            $response = new ViewResponse();
            $response->prepareError($exception);
            $response->respond();
        }

    }

    /**
     * @return void
     */
    function start(){

        if(self::$request->isView()){

            try{

                $address = $this->main_folder."/apps/Templates/".self::$request->template.".php";

                if(!file_exists($address)){
                    throw new FileNotFound("View ".$address." not found!", __FILE__, __LINE__);
                }

                $response = new ViewResponse();
                $response->prepare($address);
                $response->respond();

            }catch (LineException $exception){

                $response = new ViewResponse();
                $response->prepareError($exception);
                $response->respond();

            }

        }
        else if(self::$request->isControl()){

            $routes = Route::allRoutes();
            $callback = $routes[strtolower($_SERVER["REQUEST_METHOD"])][self::$request->route_name];

            try {

                error_clear_last();

                /** @var Response */
                $response = call_user_func($callback, self::$request->request);

                $error = error_get_last();

                if($error != null){
                    throw new ErrorUnknown($error["message"], ($error["file"] . " on line " . $error["line"]));
                }else{
                    $response->respond();
                }

            }catch (LineException $exception){

                if(self::$request->case == "API"){
                    $response = new JSONResponse();
                    $response->prepareError($exception);
                    $response->respond();
                }else{
                    $response = new ViewResponse();
                    $response->prepareError($exception);
                    $response->respond();
                }

            }

        }

    }

}
