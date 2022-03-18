<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 3/2/2020
 * Time: 3:04 PM
 */

namespace Absoft\Line\Core\DbConnection;

use Absoft\Line\Core\DbConnection\DataBases\MongoDB\MongoDB;
use Absoft\Line\Core\DbConnection\DataBases\MsSQL\MsSql;
use Absoft\Line\Core\DbConnection\DataBases\MySQL\MySql;
use Absoft\Line\Core\DbConnection\DataBases\Connection;
use Absoft\Line\Core\DbConnection\DataBases\SQLite\SQLite;
use Absoft\Line\Core\DbConnection\QueryConstruction\Query;
use Absoft\Line\Core\FaultHandling\Errors\DBConnectionError;
use Absoft\Line\Core\FaultHandling\Errors\ExecutionError;
use Application\conf\DBConfiguration;
use MongoConnectionException;
use PDO;
use PDOStatement;

class Database implements Connection {

    /** @var Connection  */
    public $subject;

    public $configuration_array;

    /** @var PDO|null  */
    public static $mysql = null;

    /** @var PDO|null  */
    public static $mssql = null;

    public static $mongo = null;


    /**
     * Database constructor.
     * @param $srv_name
     * @param $db_name
     * @throws DBConnectionError
     */
    function __construct($srv_name, $db_name){

        $this->configuration_array = DBConfiguration::$conf;

        if(sizeof($this->configuration_array) > 0 && isset($this->configuration_array[$srv_name][$db_name])){

            switch ($srv_name) {
                case "MySql":
                    $this->subject = new MySql($this->configuration_array[$srv_name][$db_name]);
                    break;
                case "MsSql":
                    $this->subject = new MsSql($this->configuration_array[$srv_name][$db_name]);
                    break;
                case "SQLite":
                    $this->subject = new SQLite($this->configuration_array[$srv_name][$db_name]);
                    break;
            }

        }

    }

    /**
     * @return PDO|null
     * @throws DBConnectionError
     */
    function getConnection(){
        return $this->subject->getConnection();
    }

    /**
     * @param $db_name
     * @return \MongoDB|null
     * @throws MongoConnectionException
     */
    static function getMongo($db_name){
        return isset(DBConfiguration::$conf["Mongo"][$db_name]) && sizeof(DBConfiguration::$conf["Mongo"][$db_name]) ? MongoDB::connect(DBConfiguration::$conf["Mongo"][$db_name]) : null;
    }

    /**
     * @param Query $query
     * @return array|bool
     * @throws ExecutionError
     */
    function execute(Query $query){
        return $this->subject->execute($query);
    }

    /**
     * @param Query $query
     * @return array|bool|null
     * @throws ExecutionError
     */
    function executeUpdate(Query $query){
        return $this->subject->executeUpdate($query);
    }

    /**
     * @param Query $query
     * @return array|bool|PDOStatement|void
     */
    function executeInReturn(Query $query){
        return $this->subject->executeInReturn($query);
    }

    /**
     * @param Query $query
     * @return array|null
     * @throws DBConnectionError
     * @throws ExecutionError
     */
    function executeFetch(Query $query){
        return $this->subject->executeFetch($query);
    }

    /**
     * @param PDO $con
     */
    static function setMysql(PDO $con){
        Database::$mysql = Database::$mysql ? Database::$mysql : $con;
    }

    /**
     * @param PDO $con
     */
    static function setMssql(PDO $con){
        Database::$mssql = Database::$mssql ? Database::$mssql : $con;
    }

    static function setMongo($con){
        Database::$mongo = Database::$mongo ? Database::$mongo : $con;
    }

    function beginTransaction(){
        return $this->subject->beginTransaction();
    }

    function commit(){
        return $this->subject->commit();
    }

    function rollback(){
        return $this->subject->rollback();
    }

    /**
     * @return int|string
     */
    function lastInsertId(){
        return $this->subject->lastInsertId();
    }

}
