<?php

use yii\db\Schema;
use yii\db\Migration;

class m151205_234908_tablas_autenticacion_api extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
          $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('hmac_keys', [
          'id' => Schema::TYPE_PK,
          'private_key' => Schema::TYPE_TEXT . ' NOT NULL',
          'public_key' => Schema::TYPE_TEXT . ' NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m151205_234908_tablas_autenticacion_api cannot be reverted.\n";

        return false;
    }

}
