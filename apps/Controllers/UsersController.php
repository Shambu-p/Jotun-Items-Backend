<?php
namespace Application\Controllers;

use Absoft\Line\Core\Modeling\Controller;
use Application\Models\UsersModel;

class UsersController extends Controller{

    function show(){
        $model = new UsersModel();
        return $this->json($model->getUsers());
    }
    
    function view($request){
        $model = new UsersModel();
        return $this->json($model->findRecord($request["id"]));
    }

    function save($request){
        $model = new UsersModel();
        return $this->json($model->createUser($request["first"], $request["middle"], $request["last"], $request["department"], $request["email"], $request["role"]));
    }
    
    public function update($request){
        $model = new UsersModel();
        return $this->json($model->change($request["id"], $request["first"], $request["middle"], $request["last"], $request["department"], $request["email"]));

    }

    public function changePassword($request){
        $model = new UsersModel();
        $user = $model->findRecord($request["user_id"]);
        if($request["conf_password"] == $request["new_password"]){
            return trigger_error("password doesn't match!");
        }



        $model->changePassword($request["id"], $request["new_password"]);
        return $this->json();
    }
    
    private function delete($request){
        //TODO: here write deleting codes to be Executed
        return "";
    }

}
?>