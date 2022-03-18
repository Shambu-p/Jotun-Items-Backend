<?php


namespace Absoft\Line\Core\FaultHandling\Exceptions;


class FileNotFound extends LineException {

    public $title = "FileNotFound Exception";
    protected $file;
    private $description;


    function __construct($file_address, $file, $line, $code = 0, \Throwable $previous = null){

        $this->description = "
        The file path ' $file_address '. does not exist";

        $this->file = $file." on line ".$line;

        parent::__construct($this->description, $code, $previous);

    }

}
