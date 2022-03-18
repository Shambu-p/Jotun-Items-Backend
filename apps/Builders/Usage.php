<?php

namespace Application\Builders;

use Absoft\Line\Core\Modeling\DbBuilders\Builder;
use Absoft\Line\Core\Modeling\DbBuilders\Schema;


class Usage extends Builder {

    function construct(Schema $table, $table_name = "Usage"){

        $this->TABLE_NAME = $table_name;

        $this->ATTRIBUTES = [
            //@att_start
            $table->int("device")->nullable(false),
            $table->int("amount")->nullable(false),
            $table->string("type")->nullable(false)->length(20),
            $table->int("date")->nullable(true)->length(20)
            //@att_end
        ];
        
        $this->HIDDEN_ATTRIBUTES = [
            //@hide_start
            //@hide_end
        ];

    }

}

        