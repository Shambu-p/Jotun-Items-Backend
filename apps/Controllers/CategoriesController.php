<?php
namespace Application\Controllers;

use Absoft\Line\Core\Modeling\Controller;
use Application\Models\CategoriesModel;

class CategoriesController extends Controller{

    public function show(){

        $model = new CategoriesModel();
        return $this->json($model->getCategory());

    }
    
    private function view($request){
        //TODO: here write viewing codes to be Executed
        return "";
    }

    function save($request){
        $model = new CategoriesModel();
        $model->addCategory($request["name"]);
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