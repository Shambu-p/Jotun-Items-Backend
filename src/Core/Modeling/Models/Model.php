<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 2/28/2021
 * Time: 12:49 PM
 */

namespace Absoft\Line\Core\Modeling\Models;


use Absoft\Line\Core\DbConnection\Database;
use Absoft\Line\Core\DbConnection\QueryConstruction\Query;
use Absoft\Line\Core\DbConnection\QueryConstruction\SQL\Deletion;
use Absoft\Line\Core\DbConnection\QueryConstruction\SQL\Insertion;
use Absoft\Line\Core\DbConnection\QueryConstruction\SQL\Selection;
use Absoft\Line\Core\DbConnection\QueryConstruction\SQL\Update;
use Absoft\Line\Core\FaultHandling\Errors\DataOutOfRangeError;
use Absoft\Line\Core\FaultHandling\Errors\DBConnectionError;
use Absoft\Line\Core\FaultHandling\Errors\EmptyArrayError;
use Absoft\Line\Core\FaultHandling\Errors\ExecutionError;
use Absoft\Line\Core\FaultHandling\Exceptions\ClassNotFound;
use Absoft\Line\Core\FaultHandling\Exceptions\ErrorFatal;
use Absoft\Line\Core\FaultHandling\Exceptions\OperationFailed;
use Exception;
use MongoConnectionException;

class Model implements ModelInterface
{

    /**
     * @var ModelInterface
     */
    private $model;
    public $MAINS;
    public $TABLE_NAME;
    public $HIDDEN;
    public $DATABASE = "MySql";
    public $DATABASE_NAME = "first";


    /**
     * Model constructor.
     * @throws DBConnectionError
     */
    public function __construct(){

        switch ($this->DATABASE){

            case "SQLite":
                $this->model = new SQLiteModel();
                $this->model->TABLE_NAME = $this->TABLE_NAME;
                $this->model->HIDDEN = $this->HIDDEN;
                $this->model->DATABASE_NAME = $this->DATABASE_NAME;
                $this->model->DATABASE = $this->DATABASE;
                $this->model->MAINS = $this->MAINS;
                $this->model->setDB();
                break;
            default:
                $this->model = new SQLModel();
                $this->model->TABLE_NAME = $this->TABLE_NAME;
                $this->model->HIDDEN = $this->HIDDEN;
                $this->model->DATABASE_NAME = $this->DATABASE_NAME;
                $this->model->DATABASE = $this->DATABASE;
                $this->model->MAINS = $this->MAINS;
                $this->model->setDB();
                break;

        }

    }

    public function findRecord($key){

        try{

            $pk = $this->getEntity()->PRIMARY_KEY;
            $query = $this->searchRecord();
            $query->where($pk, $key);
            $result = $query->fetch();

            return sizeof($result) ? $result[0] : [];
        } catch (Exception $e){
            trigger_error($e->getMessage(), E_USER_ERROR);
        }

    }

    public function searchRecord():Selection {
        try {
            return new Selection($this);
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    public function deleteRecord():Deletion {
        try {
            return new Deletion($this);
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    public function updateRecord():Update {
        try {
            return new Update($this);
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    public function addRecord():Insertion {
        try {
            return new Insertion($this);
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
        
    }

    /**
     * @param Query $query
     * @return bool
     */
    function executeUpdate(Query $query):bool {
        try {
            return $this->model->executeUpdate($query);
        } catch (DBConnectionError $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        } catch (ExecutionError $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    /**
     * @param Query $query
     * @return array|bool|null
     */
    function execute(Query $query) {
        try {
            return $this->model->execute($query);
        } catch (DBConnectionError $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        } catch (ExecutionError $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    /**
     * @param Query $query
     * @return array
     */
    function fetch(Query $query):array {
        try {
            return $this->model->fetch($query);
        } catch (DBConnectionError $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        } catch (ExecutionError $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    /**
     * @param array $search_array
     * @param array $other
     * @return array|bool|\PDOStatement
     * @throws OperationFailed|DBConnectionError
     */
    public function advancedSearch(Array $search_array, $other = []){
        return $this->model->advancedSearch($search_array, $other);
    }

    /**
     * @return mixed
     * @throws ClassNotFound
     */
    function getEntity(){
        return $this->model->getEntity();
    }

    /**
     * @param null $db
     * @throws DBConnectionError
     */
    public function setDB($db = null){
        $this->DATABASE == "MySql" ? $this->model->setDB($db) : null;
    }

    /**
     * @return Database|null
     * @throws DBConnectionError
     */
    public function getDB(){
        return $this->DATABASE == "MySql" ? $this->model->getDB() : null;
    }

    public function beginTransaction($db = null){
        return $this->DATABASE == "MySql" ? $this->model->beginTransaction($db) : null;
    }

    public function commit(){
        return $this->DATABASE == "MySql" ? $this->model->commit() : null;
    }

    public function rollback(){
        return $this->DATABASE == "MySql" ? $this->model->rollback() : null;
    }

    /**
     * @return int|string|null
     */
    public function lastInsertId(){
        return $this->DATABASE == "MySql" ? $this->model->lastInsertId() : null;
    }

    public function getModel(){
        return $this->model;
    }

}
