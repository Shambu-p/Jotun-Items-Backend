<?php


namespace Absoft\Line\Core\FaultHandling\Errors;


use Absoft\Line\Core\FaultHandling\Exceptions\LineException;

class DataOutOfRangeError extends LineException {

    public $title = "Data Out Of Range Error";
    public $file = "Model file";
    public $description;
    public $urgency = "immediate";


    function __construct($message){
        parent::__construct($message, 0, null);
        $this->description = $message;
    }

}