<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 11/5/2020
 * Time: 6:20 PM
 */
namespace Absoft\Line\Core\Modeling;

use Absoft\Line\Core\FaultHandling\Errors\DataOutOfRangeError;
use Absoft\Line\Core\FaultHandling\Errors\DBConnectionError;
use Absoft\Line\Core\FaultHandling\Exceptions\ClassNotFound;
use Absoft\Line\Core\Modeling\Models\Model;

abstract class Initializer
{

    public $VALUES;

    /**
     * @param $base_name
     * @return bool
     * @throws ClassNotFound
     * @throws DBConnectionError
     * @throws DataOutOfRangeError
     */
    public function initialize($base_name){

        $model_name = 'Application\\Models\\'.$base_name.'Model';

        /** @var Model $model */
        if($model = new $model_name){
            return $model->addMultiple($this->VALUES);
        }else{
            throw new ClassNotFound($model_name, "initializer abstract file", __LINE__);
        }

    }

}
