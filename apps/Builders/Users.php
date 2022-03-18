<?php
namespace Application\Builders;

use Absoft\Line\Core\Modeling\DbBuilders\Builder;
use Absoft\Line\Core\Modeling\DbBuilders\Schema;


class Users extends Builder{

    function construct(Schema $table, $table_name = "Users"){

        $this->TABLE_NAME = $table_name;

        $this->ATTRIBUTES = [
            //@att_start
            $table->autoincrement("id"),
            $table->string("first")->length(50)->nullable(false),
            $table->string("middle")->length(50)->nullable(false),
            $table->string("last")->length(50)->nullable(false),
            $table->string("department")->length(100)->nullable(false),
            $table->string("email")->length(100)->nullable(false),
            $table->string("role")->length(20)->nullable(false)
            //@att_end
        ];
        
        $this->HIDDEN_ATTRIBUTES = [
            //@hide_start
            $table->hidden("password")->nullable(false)
            //@hide_end
        ];

    }

}

        