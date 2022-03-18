<?php
namespace Application\Models;

use Absoft\Line\Core\Modeling\Models\Model;

class UsersModel extends Model{

    /*    public $MAINS = ["id", "username", "f_name"];    */
    
    //As the name indicate this is the Table name of the Model
    
    public $TABLE_NAME = "Users";

    /**********************************************************************
        In this property you are expected to put all the columns you want
        other than the fields you want to be hashed.
    ***********************************************************************/

    public $MAINS = ["id", "first", "middle", "last", "department", "email", "role"];
    
    /**********************************************************************
        In this field you are expected to put all columns you want to be
        encrypted or hashed.
    ***********************************************************************/
    
    public $HIDDEN = ["password"];

}
?>