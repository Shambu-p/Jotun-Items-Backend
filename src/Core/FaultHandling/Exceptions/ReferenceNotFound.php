<?php


namespace Absoft\Line\Core\FaultHandling\Exceptions;

class ReferenceNotFound extends LineException {

    private $title = "ReferenceNotFound Exception";
    protected $file = "system File";
    private $description;
    private $urgency = "immediate";


    function __construct($from, $to, $code = 0, $previous = null){

        $this->description = "There is no Reference to the Builder named ". $to." in Entity " . $from;

        parent::__construct($this->description, $code, $previous);

    }

}
