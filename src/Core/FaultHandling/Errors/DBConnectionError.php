<?php

namespace Absoft\Line\Core\FaultHandling\Errors;

use Absoft\Line\Core\FaultHandling\Exceptions\LineException;

class DBConnectionError extends LineException {

    public $title = "Database Connection Failed!";
    public $file = "Database connection file";
    public $description;
    public $urgency = "immediate";


    function __construct($srv, $host, $db_name, $message){
        parent::__construct($message, 0, null);
        $this->description = "tried to connect $srv Database server <br> location: $host<br> to database named: $db_name <br>".$message;
    }

}