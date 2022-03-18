<?php


namespace Absoft\Line\Core\FaultHandling\Exceptions;


class ClassNotFound extends LineException {

    public $title = "ClassNotFound Exception";
    public $file;
    public $description;
    public $urgency = "immediate";


    function __construct($class_name, $file, $line, $code = 0, \Throwable $previous = null){

        $this->description = "
        There is no Class named ' $class_name '. 
        this might be because the class were not defined  
        or may be it is defined incorrectly.";

        $this->file = $file." on line ".$line;

        parent::__construct($this->description, $code, $previous);

    }

}
