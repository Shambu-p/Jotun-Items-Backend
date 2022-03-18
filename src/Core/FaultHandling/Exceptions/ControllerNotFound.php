<?php

namespace Absoft\Line\Core\FaultHandling\Exceptions;

use \Throwable;

class ControllerNotFound extends LineException
{

    private $title = "ControllerNotFound Exception";
    protected $file;
    private $description;
    private $urgency = "immediate";


    function __construct($controller_name, $file, $line, $code = 0, Throwable $previous = null){

        $this->description = "
        There is no Controller named ' $controller_name '. 
        this might be because the controller not defined in routes.php 
        or may be it is defined incorrectly.";

        $this->file = $file." on line ".$line;

        parent::__construct($this->description, $code, $previous);

    }

}
