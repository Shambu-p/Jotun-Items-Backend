<?php


namespace Absoft\Line\Core\HTTP;


use Absoft\Line\Core\Engines\HTTP\Engine;
use Absoft\Line\Core\FaultHandling\Exceptions\FileNotFound;

class FileResponse extends Response
{

    /**
     * @var string
     */
    public $type;
    public $location;
    public $download;

    public function __construct(){
        parent::__construct("file");
    }

    /**
     * @var string[][]
     */
    public static $extensions = [
        "images" => ["png", "jpg", "jpeg", "ico", "svg", "gif"],
        "video" => ["mp4", "mkv", "3gp", "mov"],
    ];

    /**
     * @param $file
     * file can be file absolute location to a file needs to be responded
     * or it can be file array containing file content and other file information
     * organized in the array as follows
     * [
     *      "extension" => "file extension",
     *      "content" => "file content",
     *      "size" => "file size in bites"
     * ]
     *
     * this method should be used to force download of file.
     */
    static function fileDownload($file){

        header("Provider: Absoft");
        header("Access-Control-Allow-Origin: *");

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        if(is_array($file)){

            header('Content-Disposition: attachment; filename="'.$file["name"].'"');
            header('Content-Length: ' . $file["size"]);
            flush(); // Flush system output buffer
            print $file["content"];

        }else{

            if(file_exists($file)){

                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Content-Length: ' . filesize($file));
                flush(); // Flush system output buffer
                readfile($file);

            }else{

                if(Engine::$request->case == "API") {
                    $conditional_response = new JSONResponse();
                    $conditional_response->prepareError("FILE PATH $file DOES NOT EXIST!");
                    $conditional_response->respond();
                }else{
                    $conditional_response = new ViewResponse();
                    $conditional_response->prepareError(new FileNotFound($file, __FILE__, __LINE__));
                    $conditional_response->respond();
                }

            }

        }

    }

    /**
     * @param $file
     * file can be file absolute location to a file needs to be responded
     * or it can be file array containing file content and other file information
     * organized in the array as follows
     * [
     *      "extension" => "file extension",
     *      "content" => "file content",
     *      "size" => "file size in bites"
     * ]
     *
     * this method should be used for file streaming purpose.
     */
    static function fileContent($file){

        header("Provider: Absoft");
        header("Access-Control-Allow-Origin: *");

        if(is_array($file)){

            if(in_array(strtolower($file["extension"]), self::$extensions["images"])){
                header("Content-type: image/".$file["extension"]);
            }else{
                header("Content-type: application/".$file["extension"]);
            }

            header('Content-Length: ' . $file["size"]);
            print $file["content"];

        }else{

            if(file_exists($file)){

                $file_name = basename($file);
                $arr = explode(".", $file_name);
                $extension = (sizeof($arr) > 1) ? $arr[sizeof($arr) - 1] : "";
                if(in_array(strtolower($extension), self::$extensions["images"])){
                    header("Content-type: image/".$extension);
                }else {
                    header("Content-type: application/".$extension);
                }

                header('Content-Length: ' . filesize($file));
                print file_get_contents($file);

            }else{

                if(Engine::$request->case == "API") {
                    $conditional_response = new JSONResponse();
                    $conditional_response->prepareError("FILE PATH $file DOES NOT EXIST!");
                    $conditional_response->respond();
                }else{
                    $conditional_response = new ViewResponse();
                    $conditional_response->prepareError(new FileNotFound($file, __FILE__, __LINE__));
                    $conditional_response->respond();
                }

            }

        }

    }

    function prepare($location, $download = false){
        $this->location = $location;
        $this->download = $download;
    }

    function respond(){

        if($this->download){
            $this->fileDownload($this->location);
        }else{
            $this->fileContent($this->location);
        }

    }

    function getResponse(){
        return $this;
    }

}