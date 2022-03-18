<?php


namespace Absoft\Line\Core\FaultHandling\Exceptions;


use Throwable;

class ErrorWaning extends LineException{

    public $title = "ERROR WARNING!!!";
    public $file;
    public $description;

    function __construct($description, $error_file, $code = 0, Throwable $previous = null){
        parent::__construct($description, $code, $previous);

        $this->file = $error_file;
        $this->description = $description;

    }

}