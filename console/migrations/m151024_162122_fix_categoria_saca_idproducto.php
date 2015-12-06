<?php

use yii\db\Schema;
use yii\db\Migration;

class m151024_162122_fix_categoria_saca_idproducto extends Migration
{
    public function up()
    {
        $this->dropColumn("categoria", "idProducto");
    }

    public function down()
    {
        echo "m151024_162122_fix_categoria_saca_idproducto cannot be reverted.\n";

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
