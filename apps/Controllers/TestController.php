<?php
namespace Application\Controllers;

use Absoft\Line\Core\Modeling\Controller;
use Application\Models\UserTasksModel;

class TestController extends Controller{

    public function show($request){
        try {
            $model = new UserTasksModel();
            $qr = $model->searchRecord();
            $qr->filter(["name"]);
            $qr->filter(["email"]);
            return $this->json($qr->fetch());
        } catch (\Exception $e){
            trigger_error($e->getMessage(), E_USER_ERROR);
        }

//        return $this->display("/first_page", []);
    }
    
    public function view($request){

        $model = new UserTasksModel();
        return $this->json($model->findRecord($request["id"]));

    }

    public function save($request){

        $model = new UserTasksModel();
        $query = $model->addRecord();

        $query->add([
            "name" => "ab",
            "email" => "ab@absoft.net",
            "password" => "password"
        ]);

        $query->insert();
        return $this->json($model->findRecord($model->lastInsertId()));
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