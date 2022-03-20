<?php
namespace Application\Controllers;

use Absoft\Line\Core\Modeling\Controller;
use Application\Models\UsersModel;

class UsersController extends Controller{

    function show(){
        $model = new UsersModel();
        return $this->json($model->getUsers());
    }
    
    private function view($request){
        //TODO: here write viewing codes to be Executed
        return "";
    }

    function save($request){
        $model = new UsersModel();
        return $this->json($model->createUser($request["first"], $request["middle"], $request["last"], $request["department"], $request["email"], $request["role"]));

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