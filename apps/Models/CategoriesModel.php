<?php
namespace Application\Models;

use Absoft\Line\Core\Modeling\Models\Model;

class CategoriesModel extends Model{

    /*    public $MAINS = ["id", "username", "f_name"];    */
    
    //As the name indicate this is the Table name of the Model
    
    public $TABLE_NAME = "Categories";

    /**********************************************************************
        In this property you are expected to put all the columns you want
        other than the fields you want to be hashed.
    ***********************************************************************/

    public $MAINS = ["name"];
    
    /**********************************************************************
        In this field you are expected to put all columns you want to be
        encrypted or hashed.
    ***********************************************************************/
    
    public $HIDDEN = [];

    function getCategory(){

        $query = $this->searchRecord();
        return $query->fetch();

    }

    function addCategory($name){

        $query = $this->addRecord();
        $query->add([
            "name" => $name
        ]);
        $query->insert();

    }

}
?>