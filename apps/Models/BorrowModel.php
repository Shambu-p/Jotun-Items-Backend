<?php
namespace Application\Models;

use Absoft\Line\Core\Modeling\Models\Model;

class BorrowModel extends Model{

    /*    public $MAINS = ["id", "username", "f_name"];    */
    
    //As the name indicate this is the Table name of the Model
    
    public $TABLE_NAME = "Borrow";

    /**********************************************************************
        In this property you are expected to put all the columns you want
        other than the fields you want to be hashed.
    ***********************************************************************/

    public $MAINS = ["id", "user", "device", "taken", "returned", "status", "date"];
    
    /**********************************************************************
        In this field you are expected to put all columns you want to be
        encrypted or hashed.
    ***********************************************************************/
    
    public $HIDDEN = [];

    function requesting($user, $device, $amount){
    }

    function requestApproval($id){
    }

    function returnBorrow($id){
    }

}
?>