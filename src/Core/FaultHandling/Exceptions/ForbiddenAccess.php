<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 4/27/2021
 * Time: 12:49 AM
 */

namespace Absoft\Line\Core\FaultHandling\Exceptions;


class ForbiddenAccess extends LineException {

    private $title = "Forbidden Access Exception";
    protected $file = "Unknown file";
    private $description = "Access Denied!";
    private $urgency = "immediate";


    function __construct($code = 0, $previous = null){
        parent::__construct($this->description, $code, $previous);
    }

}
