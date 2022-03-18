<?php
namespace Application\Models;

use Absoft\Line\Core\FaultHandling\Errors\DBConnectionError;
use Absoft\Line\Core\FaultHandling\Exceptions\ClassNotFound;
use Absoft\Line\Core\FaultHandling\Exceptions\OperationFailed;
use Absoft\Line\Core\Modeling\Models\Model;

class UsageModel extends Model{

    /*    public $MAINS = ["id", "username", "f_name"];    */
    
    //As the name indicate this is the Table name of the Model
    
    public $TABLE_NAME = "Usage";

    /**********************************************************************
        In this property you are expected to put all the columns you want
        other than the fields you want to be hashed.
    ***********************************************************************/

    public $MAINS = ["device", "type", "amount", "date"];
    
    /**********************************************************************
        In this field you are expected to put all columns you want to be
        encrypted or hashed.
    ***********************************************************************/
    
    public $HIDDEN = [];

    /**
     * @return array|bool|\PDOStatement
     * @throws DBConnectionError
     * @throws OperationFailed
     */
    function getUsage(){

        return $this->advancedSearch([
            "device" => "",
            "type" => "",
            "amount" => "",
            "date" => "",
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

    /**
     * @param $device
     * @param $amount
     * @param $type
     * @throws ClassNotFound
     * @throws DBConnectionError
     * @throws OperationFailed
     */
    function newUsage($device, $amount, $type){

        $device_model = new DevicesModel();
        $result = $device_model->findRecord($device);

        if(!sizeof($result)){
            throw new OperationFailed("no device found!");
        }

        $query = $this->searchRecord();
        $query->where("device", $device);
        $query->where("type", $type);
        $usage_result = $query->fetch();

        if(sizeof($usage_result) == 1){

            $query = $this->updateRecord();
            $query->set("amount", $usage_result[0]["amount"] + $amount);
            $query->where("device", $device);
            $query->where("type", $type);
            $query->update();
            return;

        }

        $query = $this->addRecord();
        $query->add([
            "device" => $device,
            "type" => $type,
            "amount" => $amount,
            "date" => strtotime("now")
        ]);
        $query->insert();

    }

}
?>