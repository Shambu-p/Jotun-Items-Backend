<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 2/27/2021
 * Time: 8:47 PM
 */
namespace Absoft\Line\Core\HTTP;

use Absoft\Line\Core\Engines\HTTP\Engine;
use Absoft\Line\Core\FaultHandling\Exceptions\MissingParameter;
use Absoft\Line\Core\FaultHandling\Exceptions\OperationFailed;

class Request
{

    /**
     * @var \stdClass
     * this field will hold the controller name and method in the case of control request
     * in the case of page request it will hold the template address
     */
    public $template;

    /**
     * @var array
     * this filed will hold the request body which were sent
     * by using POST or GET method
     */
    public $request;

    /**
     * @var \stdClass
     * this filed will hold file requests if there was file upload
     * other wise it will hold empty object
     */
    public $file;

    /**
     * @var string
     * this filed will hold the link which initiate this construction
     * if the request were not from the client then the link will be constructed
     * if the request were from client then it will be saved here
     */
    public $link;

    /**
     * @var string
     * this filed will hold the type of request
     * wither the request is view or control request
     */
    public $type;

    /**
     * @var string
     * this filed will hold the type of request
     * wither the request is view or control request
     */
    public $case;

    /**
     * @var string
     * this filed will hold the issued route name
     */
    public $route_name;


    public function __construct(){

        $this->request = [];
        $this->link = "";
        $this->file = new \stdClass();
        $this->template = "";
        $this->type = "";

    }

    /**
     * @return bool
     * this method will check if the request is view request
     */
    public function isView(){

        if($this->type == "view"){
            return true;
        }

        return false;

    }


    /**
     * @return bool
     * this method will check if the request is control request
     */
    public function isControl(){

        if($this->type == "control"){
            return true;
        }

        return false;

    }

    /**
     * @return string
     */
    public static function hostAddress(){
        return "http://".$_SERVER["HTTP_HOST"];
    }

    /**
     * @param $parameter
     * @param $aspects
     * parameter aspects is an associative array which shows directions
     * that the request should be validated.
     * for example aspect can be as follows:
     * [
     *      "necessity" => "required",
     *      "type" => "number"
     * ]
     * necessity defines if whether the parameter is needed or not.
     * type defines what type of value expected.
     *
     * if any of the given rules fail corresponding exception will be thrown
     * @throws MissingParameter
     * @throws OperationFailed
     */
    public static function validate($parameter, $aspects){

        if(isset($aspects["necessity"]) && $aspects["necessity"] == "required"){
            self::validateNecessity($parameter);
        }

        if(isset($aspects["type"]) && $aspects["type"] == "number"){
            if(!is_numeric(Engine::$request[$parameter])){
                throw new OperationFailed("value of the parameter named $parameter expected to be number!");
            }
        }

        if(isset($aspects["type"]) && $aspects["type"] == "integer"){
            if(!is_integer(Engine::$request[$parameter])){
                throw new OperationFailed("value of the parameter named $parameter expected to be integer!");
            }
        }

        if(isset($aspects["type"]) && $aspects["type"] == "float"){
            if(!is_float(Engine::$request[$parameter])){
                throw new OperationFailed("value of the parameter named $parameter expected to be float!");
            }
        }

        if(isset($aspects["type"]) && $aspects["type"] == "double"){
            if(!is_double(Engine::$request[$parameter])){
                throw new OperationFailed("value of the parameter named $parameter expected to be double!");
            }
        }

    }

    /**
     * @param $parameter
     * @throws MissingParameter
     */
    private static function validateNecessity($parameter){

        if(!isset(Engine::$request[$parameter])){
            throw new MissingParameter(Engine::$request->link, $parameter, __FILE__, __LINE__);
        }

    }

}
