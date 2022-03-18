<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 5/28/2021
 * Time: 6:03 PM
 */

namespace Absoft\Line\Core\FaultHandling\Exceptions;


class OperationFailed extends LineException{

    public $title = "Operation Failed!";
    public $file = "unknown file";
    public $description = "";


    function __construct($message, $code = 0, $previous = null){

        $this->description = $message;
        parent::__construct($this->description, $code, $previous);

    }

}
