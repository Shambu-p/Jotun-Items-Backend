<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 5/28/2021
 * Time: 6:03 PM
 */

namespace Absoft\Line\Core\FaultHandling\Errors;


use Absoft\Line\Core\FaultHandling\Exceptions\LineException;

class OperationFailed extends LineException {

    public $title = "Operation Failed!";
    public $file = "unknown file";
    public $description;
    public $urgency = "immediate";


    function __constructor($message){
        parent::__construct($message, 0, null);
        $this->description = $message;
    }

}
