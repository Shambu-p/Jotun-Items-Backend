<?php
/**
 * Created by PhpStorm.
 * User: Abnet Kebede
 * Date: 1/18/2020
 * Time: 11:16 PM
 */

namespace Absoft\Line\Core\DbConnection\DataBases\MsSQL;

use Absoft\Line\App\Security\IpCheck;
use Absoft\Line\Core\DbConnection\Database;
use Absoft\Line\Core\DbConnection\DataBases\Connection;
use Absoft\Line\Core\DbConnection\QueryConstruction\Query;
use Absoft\Line\Core\FaultHandling\Errors\DBConnectionError;
use Absoft\Line\Core\FaultHandling\Errors\ExecutionError;
use DateTime;
use Exception;
use PDO;

class MsSql implements Connection {

    public $HOST_ADDRESS = null;
    public $DB_NAME = null;
    private $DB_USERNAME = null;
    private $DB_PASSWORD = null;

    /**
     * MsSql constructor.
     * @param array $db_info
     * @throws DBConnectionError
     */
    function __construct(array $db_info){

        $this->HOST_ADDRESS = $db_info['HOST_ADDRESS'];
        $this->DB_NAME = $db_info['DB_NAME'];
        $this->DB_USERNAME = $db_info['DB_USERNAME'];
        $this->DB_PASSWORD = $db_info['DB_PASSWORD'];

        Database::$mssql = Database::$mssql ? Database::$mssql : $this->getConnection();

    }

    /**
     * @return PDO|null
     * @throws DBConnectionError
     */
    function getConnection(){

        $return[] = null;

        try{

            $dns = "sqlsrv:Server=".$this->HOST_ADDRESS.";Database=".$this->DB_NAME;
            return new PDO($dns, $this->DB_USERNAME, $this->DB_PASSWORD);

        }catch(Exception $e){
            throw new DBConnectionError("mssql", $this->HOST_ADDRESS, $this->DB_NAME, $e->getMessage());
        }

    }

    /**
     * @param Query $query
     * @return null
     * @return array
     * @throws ExecutionError|DBConnectionError
     */
    function executeFetch(Query $query){

        $return = [];

        $data = array();
        $db = $this->getConnection();
        $status = null;
        $statement = null;

        $statement = $db->prepare($query->getQuery());

        if(sizeof($query->getValues()) == 0){
            $status = $statement->execute();
        }else{
            $status = $statement->execute($query->getValues());
        }

        if($status){

            while($row = $statement->fetch( PDO:: FETCH_ASSOC)){
                $data[] = $row;
            }

            if(sizeof($data)){

                $return['returned'] = $data;
                $return['message'] = "1";

            }else{

                $return['returned'] = $data;
                $return['message'] = "-3";

            }

        }else{

            $return['message'] = "0";
            $return['returned'] = $statement->errorInfo()[2];

            $this->generateLog($query->getQuery(), IpCheck::clientIp(), IpCheck::clientIp());

            throw new ExecutionError($statement->errorInfo()[2]);

        }

        return $return;

    }

    /**
     * @param Query $sql
     * @return null
     * @throws ExecutionError
     */
    function executeUpdate(Query $sql){

        $return = [];

        $db = Database::$mssql;
        $status = null;
        $statement = null;

        $statement = $db->prepare($sql->getQuery());

        if(sizeof($sql->getValues()) == 0){
            $status = $statement->execute();
        }else{
            $status = $statement->execute($sql->getValues());
        }

        if($status){

            $return['message'] = "1";
            $return['returned'] = $statement;

        }else{

            $this->generateLog($sql->getQuery(), "localhost", "localhost");
            $return['message'] = "0";
            $return['returned'] = ($statement->errorInfo())[2];

            throw new ExecutionError($statement->errorInfo()[2]);

        }

        return $return;

    }

    /**
     * @param $sql
     * @return array
     */
    function execute(Query $sql){

        $db = Database::$mssql;
        $status = null;
        $statement = null;

        $statement = $db->prepare($sql->getQuery());

        $status = (sizeof($sql->getValues()) == 0) ? $statement->execute() : $status = $statement->execute($sql->getValues());

        if($status){

            $return["message"] = "1";
            $return["returned"] = $status;

        }else{

            $return["message"] = "0";
            $return["returned"] = $statement->errorInfo()[2];

            new ExecutionError($statement->errorInfo()[2]);

        }

        return $return;

    }

    /**
     * @param $sql
     * @param $srvname
     * @param $ip
     * @return int|string
     */
    function generateLog($sql, $srvname, $ip){

        try{

            $nd = new DateTime();
            $time = $nd->format("H:i:s");
            $date = $nd->format("Y-m-j");
            $log = "$ip, $srvname, $sql, $time, $date \n";
            file_put_contents("../failure_log.txt", $log, FILE_APPEND);
            return 1;

        }catch(Exception $e){
            return $e->getMessage();
        }

    }

    function beginTransaction(){
        return Database::$mssql->beginTransaction();
    }

    function commit(){
        return Database::$mssql->commit();
    }

    function rollback(){
        return Database::$mssql->rollBack();
    }

    function executeInReturn(Query $query)
    {
        // TODO: Implement executeInReturn() method.
    }

    /**
     * @return integer
     */
    function lastInsertId(){
        return Database::$mssql->lastInsertId();
    }

}
