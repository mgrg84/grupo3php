<?php

use yii\db\Schema;
use yii\db\Migration;

class m151027_222332_cambio_horario_comercio extends Migration
{
    public function up()
    {
        $this->dropColumn("comercio", "horarioAtencion");
        $this->addColumn('comercio', 'horario_desde', Schema::TYPE_TIME. ' NOT NULL ');
        $this->addColumn('comercio', 'horario_hasta', Schema::TYPE_TIME . ' NOT NULL ');
    }

    public function down()
    {
        echo "m151027_222332_cambio_horario_comercio cannot be reverted.\n";

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
