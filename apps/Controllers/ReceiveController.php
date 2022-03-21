<?php
namespace Application\Controllers;

use Absoft\Line\Core\FaultHandling\Errors\DBConnectionError;
use Absoft\Line\Core\FaultHandling\Exceptions\OperationFailed;
use Absoft\Line\Core\HTTP\JSONResponse;
use Absoft\Line\Core\Modeling\Controller;
use Application\Models\ReceiveModel;

class ReceiveController extends Controller{

    /**
     * @return JSONResponse
     * @throws DBConnectionError
     * @throws OperationFailed
     */
    function show(){
        $model = new ReceiveModel();
        return $this->json($model->getReceived());
    }
    
    function view($request){
        //TODO: here write viewing codes to be Executed
        return "";
    }

    function save($request){
        $model = new ReceiveModel();
        return $this->json($model->newReceive($request["device"], $request["amount"]));
    }
    
    public function update($request){
        //TODO: here write updating codes to be Executed
        return "";
    }
    
    private function delete($request){
        //TODO: here write deleting codes to be Executed
        return "";
    }

}
?>