<?php


namespace Absoft\Line\Core\FaultHandling\Exceptions;


abstract class LineException extends \Exception{

    public $title;
    public $file;
    public $description;

    function __construct($description, $code, $previous){
        parent::__construct($description, $code, $previous);
    }

}