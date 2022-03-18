<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 6/19/2020
 * Time: 11:00 PM
 */
namespace Absoft\Line\Core\FaultHandling;

use Absoft\Line\Core\DbConnection\Attributes\SQL\Number;
use Absoft\Line\Core\FaultHandling\Exceptions\ErrorFatal;
use Absoft\Line\Core\FaultHandling\Exceptions\ErrorNotice;
use Absoft\Line\Core\FaultHandling\Exceptions\ErrorUnknown;
use Absoft\Line\Core\FaultHandling\Exceptions\ErrorWaning;

class FaultHandler{

    public static $request_type = "browser";


    /**
     * @param Number $title
     * @param string $description
     * @param string $error_file
     * @param string $urgency
     * @throws ErrorFatal
     * @throws ErrorNotice
     * @throws ErrorUnknown
     * @throws ErrorWaning
     */
    public static function reportError(Number $title, string $description, string $error_file, string $urgency = "not_immediate"){

        if($title == E_NOTICE){
            throw new ErrorNotice($description, $error_file);
        }else if($title == E_WARNING){
            throw new ErrorWaning($description, $error_file);
        }else if($title == E_ERROR){
            throw new ErrorFatal($description, $error_file);
        }else{
            throw new ErrorUnknown($description, $error_file);
        }

    }

    public static function fromCLI(){
        self::$request_type = "cli";
    }

    public static function fromBrowser(){
        self::$request_type = "browser";
    }

}
