<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 2/27/2021
 * Time: 6:01 PM
 */

namespace Absoft\Line\Core\HTTP\Decode;

use Absoft\Line\Core\FaultHandling\Exceptions\RouteNotFound;
use Absoft\Line\Core\HTTP\Request;
use Absoft\Line\Core\HTTP\Route;

class RequestAnalyzer {

    /**
     * @var Request
     * this field will hold the request object to be constructed.
     */
    private $request;

    /**
     * RequestAnalyzer constructor.
     * this method will initiate the request analysis by taking input from engine or
     * by initiating address analyzer
     * @throws RouteNotFound
     */
    function __construct() {

        $this->request = new Request();
        $this->addressAnalyzer();

    }

    /**
     * this method will setup arguments, which are sent using get or post for use
     */
    private function getArguments(){
        $this->request->request = ($_SERVER["REQUEST_METHOD"] == "GET") ? $_GET : $_POST;
    }

    /**
     * this method will fetch all sent file for easy use in object format
     */
    private function getFiles(){

        if(sizeof($_FILES) > 0){
            $this->request->file = json_decode(json_encode($_FILES));
        }

    }

    /**
     * return
     * this method read the request URI and then construct the request
     * by dividing the request to header, requests and request files.
     */
    private function addressAnalyzer(){

        if(strpos($_SERVER["REQUEST_URI"], "?") >= 0){

            $uri = explode("?", $_SERVER["REQUEST_URI"]);
            $route_name = $uri[0];
            $this->request->link = ($route_name == "") ? "/" : Request::hostAddress().$route_name;

        }else{

            $route_name = $_SERVER["REQUEST_URI"];
            $this->request->link = Request::hostAddress().$route_name;

        }

        $routes = Route::allRoutes();
        $method = $_SERVER["REQUEST_METHOD"] == "GET" ? "get" : "post";

        if($route_name != "/" || $route_name != ""){

            $segment = explode("/", $route_name);
            $this->request->case = ($segment[1] == "api") ? "API" : "UI";

        }else{
            $this->request->case = "UI";
        }

        if(!isset($routes[$method][$route_name])){
            $_SERVER["REQUEST_METHOD"] = "GET";
            $method = "get";
            $route_name = $this->request->case == "UI" ? "/404" : "/api/404";
            $this->request->link = Request::hostAddress().$route_name;
        }

        $this->request->route_name = $route_name;
        $this->request->type = is_string($routes[$method][$route_name]) ? "view" : "control";
        $this->request->template = $this->request->type == "view" ? $routes[$method][$route_name] : "";

        $this->getFiles();
        $this->getArguments();

    }

    /**
     * @return Request
     * this will return the constructed request.
     */
    public function getRequest(){
        return $this->request;
    }

}
