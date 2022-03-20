<?php
namespace Application\Controllers;

use Absoft\Line\Core\Modeling\Controller;
use Application\Models\DepartmentsModel;

class DepartmentsController extends Controller{

    function show(){
        $model = new DepartmentsModel();
        return $this->json($model->getDepartments());
    }
    
//    private function view($request){}

    function save($request){
        $model = new DepartmentsModel();
        $model->addDepartment($request["name"]);
        return $this->json(["name" => $request["name"]]);
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