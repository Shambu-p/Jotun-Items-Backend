<?php
namespace Application\Initializers;

use Absoft\Line\Core\Modeling\Initializer;

class UserTasksInitializer extends Initializer{

    /*
    public $VALUES = [
        [
            "id" => "the_id",
            "name" => "the_name",
        ],
        [
            "id" => "the_id",
            "name" => "the_name"
        ]
    ];

    */
    
    public $BUILDER = "UserTasks";

    /*************************************************************************
        In this property you are expected to put all the values you want
        to insert into database. the you can initialize the operation from
        line cli.
    *************************************************************************/

    public $VALUES = [
        [
            "name" => "ab",
            "email" => "ab@absoft.net",
            "password" => "password"
        ],
        [
            "name" => "abu",
            "email" => "abu@absoft.net",
            "password" => "password"
        ]
    ];
    
}
?>