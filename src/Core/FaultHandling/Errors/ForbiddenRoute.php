<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 4/27/2021
 * Time: 12:21 AM
 */

namespace Absoft\Line\Core\FaultHandling\Errors;


use Absoft\Line\Core\FaultHandling\Exceptions\LineException;

class ForbiddenRoute extends LineException {

    public $title = "Forbidden Route!";
    public $file = "Model file";
    public $description = "The address that you are trying to access is forbidden!";
    public $urgency = "immediate";


    function __construct(){
        parent::__construct($this->description, 0, null);
    }

}
