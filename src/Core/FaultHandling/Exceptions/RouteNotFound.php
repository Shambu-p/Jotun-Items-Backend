<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 6/19/2020
 * Time: 11:00 PM
 */

namespace Absoft\Line\Core\FaultHandling\Exceptions;


class RouteNotFound extends LineException {

    private $title = "RouteNotFound Exception";
    protected $file = "SystemConstructor/App/Routing/route.php";
    private $description = "";
    private $urgency = "immediate";


    function __construct($route_name = "unknown", $code = 0, $previous = null)
    {

        $this->description = "there is no route named $route_name ";
        parent::__construct($this->description, $code, $previous);

    }

}
