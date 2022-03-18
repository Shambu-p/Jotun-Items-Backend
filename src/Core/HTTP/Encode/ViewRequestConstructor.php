<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 2/27/2021
 * Time: 8:51 PM
 */
namespace Absoft\Line\Core\HTTP\Encode;

use Absoft\Line\Core\FaultHandling\Exceptions\MissingParameter;
use Absoft\Line\Core\FaultHandling\Exceptions\RouteNotFound;
use Absoft\Line\Core\HTTP\DataTransfer;
use Absoft\Line\Core\HTTP\Request;
use Absoft\Line\Core\HTTP\Route;

class ViewRequestConstructor extends RequestConstructor
{

    /**
     * @var Request
     */
    public $request;


    function __construct($route_name, $request, $files = [])
    {
        parent::__construct($route_name, $request, $files);
    }

    /**
     * @param $route_name string
     * this method accept route name as string
     * for page routing the parent and sub folder name will be
     * written with dot in between.
     * here the header of the request will be produced
     */
    function headerConstruction(string $route_name)
    {

        $return = new \stdClass();
        $return->page_name = "";
        $return->sub_page = "";
        $arr = explode(".", $route_name);

        if(sizeof($arr) == 2 && $arr[0] && $arr[1]){

            $return->page_name = $arr[0];
            $return->sub_page = $arr[1];

        }

        $this->request->header = $return;

    }

    /**
     * @param string $route_name
     * @param array $request
     * @param array $files
     * TODO here is where the request construction organized by using the other methods
     */
    function mainConstruction(string $route_name, array $request, array $files) {

        try{

            $this->headerConstruction($route_name);
            $this->requestConstruction($this->request->header, $request);
            $this->fileConstruction($files);
            $this->request->type = "view";

        } catch (MissingParameter $ex){
            $ex->report();
        } catch (RouteNotFound $e) {
            $e->report();
        }

    }

    /**
     * @param \stdClass $header
     * @param array $request_array
     * @throws MissingParameter
     * @throws RouteNotFound
     */
    function requestConstruction(\stdClass $header, array $request_array)
    {

        //$request = '';
        $req_array = [];
        $route_address = Route::getRoute("/pages/".$header->page_name."/".$header->sub_page);


        if($route_address){

            $str = explode("/", $route_address);

            foreach ($str as $key => $value){

                if($key > 0){

                    if(isset($request_array[$value])){
                        $req_array[$value] = $request_array[$value];
                    }else{
                        throw new MissingParameter("/pages/".$header->page_name."/".$header->sub_page, $value, __FILE__, __LINE__);
                    }

                }

            }

        }else{
            $req_array = $request_array;
        }

        $this->request->request = (object) $req_array;
        DataTransfer::set("/pages/".$header->page_name."/".$header->sub_page, $req_array);
        $this->request->link = Request::hostAddress()."/pages/".$header->page_name."/".$header->sub_page;

    }
}
