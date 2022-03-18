<?php
namespace Application\Controllers;

use Absoft\Line\Core\Modeling\Controller;
use Application\Models\DevicesModel;

class DevicesController extends Controller{

    public function show($request){

        $model = new DevicesModel();
        return $this->json($model->getDevices());

    }

    function view($request){
        $model = new DevicesModel();
        return $this->json($model->findRecord($request["id"]));
    }

    function save($request){

        $model = new DevicesModel();
        return $this->json($model->addDevice($request["name"], $request["type"], $request["amount"]));

    }
    
    public function update($request){
        $model = new DevicesModel();
        return $this->json($model->edit($request["id"], $request["name"], $request["amount"], $request["type"]));
    }
    
    private function delete($request){
        //TODO: here write deleting codes to be Executed
        return "";
    }

}
?>