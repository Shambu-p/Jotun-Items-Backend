<?php

use Absoft\Line\Core\Engines\HTTP\Engine;
use Absoft\Line\Core\FaultHandling\Exceptions\ErrorFatal;
use Absoft\Line\Core\FaultHandling\Exceptions\ErrorNotice;
use Absoft\Line\Core\FaultHandling\Exceptions\ErrorUnknown;
use Absoft\Line\Core\FaultHandling\Exceptions\ErrorWaning;
use Absoft\Line\Core\FaultHandling\FaultHandler;
use Absoft\Line\Core\FaultHandling\Exceptions\LineException;
use Absoft\Line\Core\HTTP\JSONResponse;
use Absoft\Line\Core\HTTP\ViewResponse;

ini_set('display_errors', 0);

error_reporting(-1);
//register_shutdown_function('shutDown');
set_error_handler('ErrorHandler', E_ALL);

function ErrorHandler($error_type, $error_message, $error_file, $error_line) {

    try{

        if($error_type == E_NOTICE){
            throw new ErrorNotice($error_message, ($error_file . " on line " . $error_line));
        }else if($error_type == E_WARNING){
            throw new ErrorWaning($error_message, ($error_file . " on line " . $error_line));
        }else if($error_type == E_ERROR){
            throw new ErrorFatal($error_message, ($error_file . " on line " . $error_line));
        }else{
            throw new ErrorUnknown($error_message, ($error_file . " on line " . $error_line));
        }

    }catch (LineException $ex){
        if(FaultHandler::$request_type == "browser"){
            if(Engine::$request->case == "API"){
                $response = new JSONResponse();
                $response->prepareError($ex->description);
                $response->respond();
            }else{
                $response = new ViewResponse();
                $response->prepareError($ex);
                $response->respond();
            }
        }else{
            echo $ex->description."\n";
        }

    }
    die();

}
