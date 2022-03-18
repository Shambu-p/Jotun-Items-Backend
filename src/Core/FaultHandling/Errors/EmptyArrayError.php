<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 6/19/2020
 * Time: 11:00 PM
 */

namespace Absoft\Line\Core\FaultHandling\Errors;


use Absoft\Line\Core\FaultHandling\Exceptions\LineException;

class EmptyArrayError extends LineException {

    public $title = "Empty Array Passed!";
    public $file = "Model file";
    public $description;


    function __construct($message){
        parent::__construct($message, 0, null);
        $this->description = $message;
    }

}