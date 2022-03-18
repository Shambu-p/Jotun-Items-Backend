<?php


namespace Absoft\Line\Core\HTTP;


use Absoft\Line\App\Files\DirConfiguration;
use Absoft\Line\Core\Engines\HTTP\Engine;
use Absoft\Line\Core\Engines\HTTP\ViewerEngine;
use Absoft\Line\Core\FaultHandling\Exceptions\LineException;
use Application\conf\ErrorConfiguration;

class ViewResponse extends Response
{

    /**
     * @var string
     */
    public $type;
    private $content = "";

    public function __construct(){
        parent::__construct("view");
    }

    public function prepare($location, $request_data = null){

        http_response_code(200);

        $loadTemplate = function ($location){
            ViewResponse::addLayout($location);
        };

        $request = $request_data ?? Engine::$request->request;

        ob_start();
        include_once $location;
        $this->content = ob_get_clean();

    }

    public function prepareError(LineException $exception = null){

        $location = ErrorConfiguration::$conf["error_page"] == "" ? dirname(dirname(__DIR__))."/App/Templates/error/index.php" : $_SERVER["DOCUMENT_ROOT"]."/apps/Templates".ErrorConfiguration::$conf["error_page"];

        http_response_code(501);

        $request = $exception ? [
            "title" => $exception->title,
            "description" => $exception->description,
            "file" => $exception->file
        ] : [
            "title" => "Unknown",
            "description" => "Unknown",
            "file" => "Unknown"
        ];

        ob_start();
        include_once $location;
        $this->content = ob_get_clean();

    }

    static function addLayout($location){
        include_once DirConfiguration::$_main_folder."/apps/Templates".$location.".php";
    }

    public function respond(){
        echo $this->content;
    }

}