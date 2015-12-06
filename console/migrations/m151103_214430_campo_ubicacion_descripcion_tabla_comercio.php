<?php

use yii\db\Schema;
use yii\db\Migration;

class m151103_214430_campo_ubicacion_descripcion_tabla_comercio extends Migration
{
    public function up()
    {
        $this->addColumn('comercio', 'ubicacion_descripcion', Schema::TYPE_STRING . '(32)', ' NOT NULL ');
    }

    public function down()
    {
        echo "m151103_214430_campo_ubicacion_descripcion_tabla_comercio cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
