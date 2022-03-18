<?php
namespace Application\Models;

use Absoft\Line\Core\FaultHandling\Errors\DBConnectionError;
use Absoft\Line\Core\FaultHandling\Exceptions\OperationFailed;
use Absoft\Line\Core\FaultHandling\Exceptions\ClassNotFound;
use Absoft\Line\Core\Modeling\Models\Model;

class ReceiveModel extends Model{

    /*    public $MAINS = ["id", "username", "f_name"];    */
    
    //As the name indicate this is the Table name of the Model
    
    public $TABLE_NAME = "Receive";

    /**********************************************************************
        In this property you are expected to put all the columns you want
        other than the fields you want to be hashed.
    ***********************************************************************/

    public $MAINS = ["device", "date", "amount"];
    
    /**********************************************************************
        In this field you are expected to put all columns you want to be
        encrypted or hashed.
    ***********************************************************************/
    
    public $HIDDEN = [];


    /**
     * @param $device
     * @param $amount
     * @throws DBConnectionError
     * @throws ClassNotFound
     * @throws OperationFailed
     */
    function newReceive($device, $amount){

        $device_model = new DevicesModel();
        $result = $device_model->findRecord($device);

        if(!sizeof($result)){
            throw new OperationFailed("cannot get device");
        }


        $this->beginTransaction();
        $query = $this->addRecord();
        $query->add([
            "device" => $device,
            "amount" => $amount,
            "date" => strtotime("now")
        ]);
        $query->insert();


        $query = $device_model->updateRecord();
        $query->set("amount", $result["amount"] + $amount);
        $query->where("id", $device);

        if(!$query->update()){
            $this->rollback();
        }

        $device_model->commit();

    }

    /**
     * @return array|bool|\PDOStatement
     * @throws DBConnectionError
     * @throws OperationFailed
     */
    function getReceived(){

        return $this->advancedSearch([
            "device" => "",
            "date" => "",
            "amount" => "",
            "join" => [
                [
                    ":table" => "Devices",
                    ":on" => "id",
                    ":parent" => "device",
                    ":as" => "device",

                    "id" => "",
                    "email" => "",
                    "first" => "",
                    "middle" => "",
                    "last" => "",
                    "role" => "",
                    "department" => ""
                ]
            ]
        ]);

    }

}
?>