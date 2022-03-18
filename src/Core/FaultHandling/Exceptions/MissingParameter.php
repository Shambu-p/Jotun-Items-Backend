<?php

namespace Absoft\Line\Core\FaultHandling\Exceptions;


class MissingParameter extends LineException
{

    private $title = "MissingParameter Exception";
    protected $file;
    private $description;
    private $urgency = "immediate";


    function __construct($link, $parameter, $file, $line, $code = 0, \Throwable $previous = null)
    {

        $this->description = "In route ".$link." parameter named ".$parameter." missed.";
        $this->file = $file." on line ".$file;

        parent::__construct($this->description, $code, $previous);

    }

}
