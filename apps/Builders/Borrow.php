<?php
namespace Application\Builders;

use Absoft\Line\Core\Modeling\DbBuilders\Builder;
use Absoft\Line\Core\Modeling\DbBuilders\Schema;


class Borrow extends Builder{

    function construct(Schema $table, $table_name = "Borrow"){

        $this->TABLE_NAME = $table_name;

        $this->ATTRIBUTES = [
            //@att_start
            $table->autoincrement("id"),
            $table->int("user")->nullable(false),
            $table->int("device")->nullable(false),
            $table->int("taken")->nullable(false),
            $table->int("returned")->nullable(false),
            $table->string("status")->nullable(false)->length(20),
            $table->int("date")->nullable(true)->length(20)
            //@att_end
        ];
        
        $this->HIDDEN_ATTRIBUTES = [
            //@hide_start
            //@hide_end
        ];

    }

}

        