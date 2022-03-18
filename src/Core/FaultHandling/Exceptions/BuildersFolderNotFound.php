<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 5/26/2021
 * Time: 9:57 AM
 */

namespace Absoft\Line\Core\FaultHandling\Exceptions;


class BuildersFolderNotFound extends LineException {

    private $title = "BuildersFolderNotFound Exception";
    protected $file;
    private $description;
    private $urgency = "immediate";


    function __construct($file_address, $file, $line, $code = 0, \Throwable $previous = null){

        $this->description = "
        There is no directory with address ' $file_address '. does not exist \n it is because the Builders folder address is changed in DirConfiguration file.";

        $this->file = $file." on line ".$line;

        parent::__construct($this->description, $code, $previous);

    }

}
