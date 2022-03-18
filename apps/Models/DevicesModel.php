<?php
namespace Application\Models;

use Absoft\Line\Core\Modeling\Models\Model;

class DevicesModel extends Model{

    /*    public $MAINS = ["id", "username", "f_name"];    */
    
    //As the name indicate this is the Table name of the Model
    
    public $TABLE_NAME = "Devices";

    /**********************************************************************
        In this property you are expected to put all the columns you want
        other than the fields you want to be hashed.
    ***********************************************************************/

    public $MAINS = ["id", "name", "type", "amount"];
    
    /**********************************************************************
        In this field you are expected to put all columns you want to be
        encrypted or hashed.
    ***********************************************************************/
    
    public $HIDDEN = [];

    function addDevice($name, $type, $amount){

        $query = $this->addRecord();
        $query->add([
            "name" => $name,
            "type" => $type,
            "amount" => $amount
        ]);
        $query->insert();

        return [
            "id" => $this->lastInsertId(),
            "name" => $name,
            "type" => $type,
            "amount" => $amount
        ];

    }

    function edit($id, $name, $amount, $type){

        $query = $this->updateRecord();
        $query->set("name", $name);
        $query->set("type", $type);
        $query->set("amount", $amount);
        $query->where("id", $id);
        $query->update();

        return [
            "id" => $id,
            "name" => $name,
            "type" => $type,
            "amount" => $amount
        ];

    }

    function getDevices(){
        $query = $this->searchRecord();
        return $query->fetch();
    }

}
?>