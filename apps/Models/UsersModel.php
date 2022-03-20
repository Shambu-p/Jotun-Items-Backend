<?php
namespace Application\Models;

use Absoft\Line\Core\FaultHandling\Exceptions\OperationFailed;
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

    function getUsers(){
        $query = $this->searchRecord();
        $query->filter(["id", "first", "middle", "last", "department", "email", "role"]);
        return $query->fetch();
    }

    function createUser($first_name, $middle_name, $last_name, $department, $email, $role){

        $query = $this->addRecord();
        $query->add([
            "first" => $first_name,
            "middle" => $middle_name,
            "last" => $last_name,
            "department" => $department,
            "email" => $email,
            "role" => $role,
            "password" => "password"
        ]);
        $query->insert();

        return [
            "id" => $this->lastInsertId(),
            "first" => $first_name,
            "middle" => $middle_name,
            "last" => $last_name,
            "department" => $department,
            "email" => $email,
            "role" => $role,
            "password" => "password"
        ];

    }

    /**
     * @param $id
     * @param $password
     * @return array|mixed
     * @throws OperationFailed
     */
    function changePassword($id, $password){

        $result = $query = $this->findRecord($id);

        if(sizeof($result) == 0){
            throw new OperationFailed("User not found");
        }

        $query = $this->updateRecord();
        $query->set("password", $password);
        $query->where("id", $id);
        $query->update();

        $result["password"] = "";
        return $result;

    }

    /**
     * @param $id
     * @param $role
     * @return array|mixed
     * @throws OperationFailed
     */
    function changePrivilege($id, $role){

        $result = $query = $this->findRecord($id);

        if(sizeof($result) == 0){
            throw new OperationFailed("User not found");
        }

        $query = $this->updateRecord();
        $query->set("role", $role);
        $query->where("id", $id);
        $query->update();

        $result["password"] = "";
        $result["role"] = $role;
        return $result;

    }

    /**
     * @param $id
     * @param $first
     * @param $middle
     * @param $last
     * @param $department
     * @param $email
     * @return array|mixed
     * @throws OperationFailed
     */
    function change($id, $first, $middle, $last, $department, $email){

        $result = $query = $this->findRecord($id);

        if(sizeof($result) == 0){
            throw new OperationFailed("User not found");
        }

        $query = $this->updateRecord();

        $query->set("first", $first);
        $query->set("middle", $middle);
        $query->set("last", $last);
        $query->set("department", $department);
        $query->set("email", $email);

        $query->where("id", $id);
        $query->update();

        $result["password"] = "";
        return $result;

    }

}
?>