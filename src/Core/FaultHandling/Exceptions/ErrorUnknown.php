<?php


namespace Absoft\Line\Core\FaultHandling\Exceptions;


use Throwable;

class ErrorUnknown extends LineException {

    public $title = "FATAL ERROR!!!";
    public $file;
    public $description;

    /**
     * ErrorUnknown constructor.
     * @param $description
     * @param $error_file
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($description, $error_file, $code = 0, Throwable $previous = null){
        parent::__construct($description, $code, $previous);

        $this->file = $error_file;
        $this->description = $description;

    }

}