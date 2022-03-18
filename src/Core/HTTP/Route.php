<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 2/27/2021
 * Time: 9:42 PM
 */
namespace Absoft\Line\Core\HTTP;

use Absoft\Line\Core\FaultHandling\Exceptions\DefaultRouteNotFound;
use Absoft\Line\Core\FaultHandling\Exceptions\RouteNotFound;
use Absoft\Line\Core\HTTP\Encode\ControlRequestConstructor;
use Absoft\Line\Core\HTTP\Encode\ViewRequestConstructor;

class Route {


    /**
     * @var array
     * this field will hold all the routes available for this particular client
     */
    private static $route_array = [];
    private static $default = [];


    /**
     * @param $route_name String
     * @param $request array
     * this method take route name and requests
     * as result it will generate or construct URL
     * this method can be used in views for generating link.
     * @return string
     */
    public static function routeAddress($route_name, $request){

        $construction = new ControlRequestConstructor($route_name, $request);
        return $construction->getRequest()->link;

    }

    /**
     * @param $route_name
     * @param $request
     *
     * this method take route name and request array
     * as a result it will redirect to that route and pass the request
     * the method uses the URL generated in routeAddress method
     *
     * this method is important for developers to redirect
     * from one controller to another controller
     */
    public static function goRoute($route_name, $request = []){

        header("location: ".Route::routeAddress($route_name, $request));
        die();

    }

    /**
     * @param $route_name
     * this method will redirect to route name passed to it as parameter.
     */
    public static function go($route_name){
        header("location: ".Request::hostAddress().$route_name);
        die();
    }

    /**
     * @param $route_name
     * @return string
     * this method will return link to the route name provided as parameter.
     */
    public static function address($route_name){
        return Request::hostAddress().$route_name;
    }

    /**
     * @param $page_name
     * @param $sub_page
     * @param $request
     * @return Request
     */
    public static function display($page_name, $sub_page, $request = []){

        $construction = new ViewRequestConstructor($page_name.".".$sub_page, $request);
        return $construction->getRequest();

    }

    /**
     * @param $route_name
     * @param $request
     * @return Request
     */
    public static function route($route_name, $request = []){

        $construction = new ControlRequestConstructor($route_name, $request);
        return $construction->getRequest();

    }

    /**
     * @param $route_name
     * @param $callback
     * this callback can be a view address in templates folder
     * or it can be function which will be executed.
     * functions can be specified in two ways
     * first:
     * Route::post("/route_name", function ($request){
     *      //do something
     * });
     *
     * second:
     * Route::post("/route_name", [controller_object_instance, 'method_name']);
     */
    public static function post($route_name, $callback){
        Route::$route_array["post"][$route_name] = $callback;
    }

    /**
     * @param $route_name
     * @param $callback
     * this callback can be a view address in templates folder
     * or it can be function which will be executed.
     * functions can be specified in two ways
     * first:
     * Route::get("/route_name", function ($request){
     *      //do something
     * });
     *
     * second:
     * Route::get("/route_name", [controller_object_instance, 'method_name']);
     */
    public static function get($route_name, $callback){
        Route::$route_array["get"][$route_name] = $callback;
    }

    /**
     * @param $page_name
     * @param $sub_page
     * @param $request
     * this method take page name and sub page name of a view and request for that particular view
     * and as a result it will generate URL to invoke that view.
     * @return string
     */
    public static function viewAddress($page_name, $sub_page, $request = []){

        $construction = new ViewRequestConstructor($page_name.".".$sub_page, $request);
        return $construction->getRequest()->link;

    }

    /**
     * @param $page_name
     * @param $sub_page
     * @param $request
     *
     * this method uses viewAddress method to generate view URL and
     * by using the generated URL it will redirect to that particular view as result.
     */
    public static function view($page_name, $sub_page, $request = []){

        header("location: ".Route::viewAddress($page_name, $sub_page, $request));
        die();

    }

    /**
     * @param $route_name
     * @param $parameters
     *
     * this method save route name and route parameters in route_array field
     */
    public static function set($route_name, $parameters){
        Route::$route_array[$route_name] = $parameters;
    }

    /**
     * @param string $controller
     * @param string $method
     */
    public static function setDefault($controller, $method){

        Route::$default["controller"] = $controller;
        Route::$default["method"] = $method;

    }

    /**
     * @return array
     * @throws DefaultRouteNotFound
     */
    public static function getDefault(){

        if(sizeof(Route::$default) == 2){
            return Route::$default;
        }else{
            throw new DefaultRouteNotFound();
        }

    }

    /**
     * @param $route_name string
     * @return string
     * this method will take route name as parameter and then
     * it will return all the parameters needed to this particular route as string
     * @throws RouteNotFound
     */
    public static function getRoute($route_name){

        if(isset(Route::$route_array[$route_name])){
            return Route::$route_array[$route_name];
        }
        else{
            throw new RouteNotFound($route_name);
        }

    }

    /**
     * @return array
     * this method will return all the routes available for this particular client
     */
    public static function allRoutes(){
        return Route::$route_array;
    }

}
