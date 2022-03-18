<?php

namespace Absoft\Line\Core\FaultHandling\Errors;

use Absoft\Line\Core\FaultHandling\Exceptions\LineException;

class ExecutionError extends LineException {

    public $title = "Query Execution Failed!";
    public $file = "Database connection file";
    public $description;
    public $urgency = "immediate";


    function __construct($message){
        parent::__construct($message, 0, null);
        $this->description = $message;
    }

}