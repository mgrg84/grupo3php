<?php

use yii\db\Schema;
use yii\db\Migration;

class m151019_225821_crear_tablas_basicas extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
          $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        //CATEGORIA
        $this->createTable('categoria', [
          'id' => Schema::TYPE_PK,
          'nombre' => Schema::TYPE_TEXT.' NOT NULL DEFAULT ""',
          'idProducto' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        //PRODUCTO
        $this->createTable('producto', [
          'id' => Schema::TYPE_PK,
          'nombre' => Schema::TYPE_TEXT.' NOT NULL DEFAULT ""',
          'imagen' => Schema::TYPE_TEXT.' NOT NULL DEFAULT ""',
          'idCategoria' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        //JOIN TABLE PRODUCTOS DE UNA CATEGORIA
        $this->createTable('categoria_productos', [
          'id' => Schema::TYPE_PK,
          'idCategoria' => Schema::TYPE_INTEGER . ' NOT NULL',
          'idProducto' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        //PEDIDO
        $this->createTable('pedido', [
          'id' => Schema::TYPE_PK,
          'cantidad' => Schema::TYPE_INTEGER . ' NOT NULL',
          'fecha' => Schema::TYPE_DATE . ' NOT NULL',
          'idUsuario' => Schema::TYPE_INTEGER . ' NOT NULL',
          'idProducto' => Schema::TYPE_INTEGER . ' NOT NULL',
          'idComercio' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        //STOCK
        $this->createTable('stock', [
          'id' => Schema::TYPE_PK,
          'cantidad' => Schema::TYPE_INTEGER . ' NOT NULL',
          'fecha' => Schema::TYPE_DATE . ' NOT NULL',
          'idUsuario' => Schema::TYPE_INTEGER . ' NOT NULL',
          'idProducto' => Schema::TYPE_INTEGER . ' NOT NULL',
          'idComercio' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        //COMERCIO
        $this->createTable('comercio', [
          'id' => Schema::TYPE_PK,
          'nombre' => Schema::TYPE_TEXT . ' NOT NULL',
          'ubicacion' => Schema::TYPE_TEXT . ' NOT NULL',
          'prioridad' => Schema::TYPE_INTEGER . ' NOT NULL',
          'horarioAtencion' => Schema::TYPE_TEXT . ' NOT NULL',
          'lunes' => Schema::TYPE_BOOLEAN . ' NOT NULL',
          'martes' => Schema::TYPE_BOOLEAN . ' NOT NULL',
          'miercoles' => Schema::TYPE_BOOLEAN . ' NOT NULL',
          'jueves' => Schema::TYPE_BOOLEAN . ' NOT NULL',
          'viernes' => Schema::TYPE_BOOLEAN . ' NOT NULL',
          'sabado' => Schema::TYPE_BOOLEAN . ' NOT NULL',
          'domingo' => Schema::TYPE_BOOLEAN . ' NOT NULL',
        ], $tableOptions);
        //JOIN TABLE PEDIDOS DE UN COMERCIO
        $this->createTable('comercio_pedidos', [
          'id' => Schema::TYPE_PK,
          'idComercio' => Schema::TYPE_INTEGER . ' NOT NULL',
          'idPedido' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        //JOIN TABLE STOCKS DE UN COMERCIO
        $this->createTable('comercio_stocks', [
          'id' => Schema::TYPE_PK,
          'idComercio' => Schema::TYPE_INTEGER . ' NOT NULL',
          'idStock' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        //RUTA
        $this->createTable('ruta', [
          'id' => Schema::TYPE_PK,
          'idUsuario' => Schema::TYPE_INTEGER . ' NOT NULL',
          'fecha' => Schema::TYPE_DATE . ' NOT NULL',
        ], $tableOptions);
        //JOIN TABLE RUTAS DE UN USUARIO
        $this->createTable('user_rutas', [
          'id' => Schema::TYPE_PK,
          'idUsuario' => Schema::TYPE_INTEGER . ' NOT NULL',
          'idRuta' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        //JOIN TABLE COMERCIOS DE UNA RUTA
        $this->createTable('ruta_comercios', [
          'id' => Schema::TYPE_PK,
          'idRuta' => Schema::TYPE_INTEGER . ' NOT NULL',
          'idComercio' => Schema::TYPE_INTEGER . ' NOT NULL',
          'recorrido' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT false',
        ], $tableOptions);
        //ALTER TABLE PARA AGREGAR UBICACION_DOMICILIO AL USUARIO
        $this->addColumn('user', 'ubicacionDomicilio', Schema::TYPE_TEXT . ' NOT NULL DEFAULT ""');


        //CLAVE FORANEA: idCategoria en producto => id en categoria
        $this->addForeignKey("fk_prod_cat", "producto", "idCategoria", "categoria", "id");

        $this->addForeignKey("fk_cat_prods_cat", "categoria_productos", "idCategoria", "categoria", "id");

        $this->addForeignKey("fk_cat_prods_prod", "categoria_productos", "idProducto", "producto", "id");

        $this->addForeignKey("fk_pedido_prod", "pedido", "idProducto", "producto", "id");
        $this->addForeignKey("fk_pedido_user", "pedido", "idUsuario", "user", "id");
        $this->addForeignKey("fk_pedido_comer", "pedido", "idComercio", "comercio", "id");

        $this->addForeignKey("fk_stock_prod", "stock", "idProducto", "producto", "id");
        $this->addForeignKey("fk_stock_user", "stock", "idUsuario", "user", "id");
        $this->addForeignKey("fk_stock_comer", "stock", "idComercio", "comercio", "id");

        $this->addForeignKey("fk_comercio_ped_ped", "comercio_pedidos", "idPedido", "pedido", "id");
        $this->addForeignKey("fk_comercio_ped_comer", "comercio_pedidos", "idComercio", "comercio", "id");

        $this->addForeignKey("fk_comercio_stock_stock", "comercio_stocks", "idStock", "stock", "id");
        $this->addForeignKey("fk_comercio_stock_comer", "comercio_stocks", "idComercio", "comercio", "id");

        $this->addForeignKey("fk_ruta_user", "ruta", "idUsuario", "user", "id");

        $this->addForeignKey("fk_user_ruta_user", "user_rutas", "idUsuario", "user", "id");
        $this->addForeignKey("fk_user_ruta_ruta", "user_rutas", "idRuta", "ruta", "id");

        $this->addForeignKey("fk_ruta_comer_ruta", "ruta_comercios", "idRuta", "ruta", "id");
        $this->addForeignKey("fk_ruta_comer_comer", "ruta_comercios", "idComercio", "comercio", "id");


    }

    public function down()
    {
        echo "m151019_225821_crear_tablas_basicas cannot be reverted.\nGood day. Fuck off now.\n";

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
