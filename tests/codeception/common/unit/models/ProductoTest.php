<?php

namespace tests\codeception\common\unit\models;

use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;
use common\models\Producto;
use tests\codeception\common\fixtures\ProductoFixture;

/**
 * Login form test
 */
class ProductoTest extends DbTestCase
{

    use Specify;

    public function setUp()
    {
        parent::setUp();

    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testCreate()
    {
        $model = new Producto([
            'nombre' => 'Nuevo Producto',
            'idCategoria' => '1'
        ]);

        $model->save();

        $this->specify('Que se haya creado un Producto', function () use ($model){
           
            expect('Que exista un producto con ese nombre', $model->attributes['nombre']=='Nuevo Producto')->true();

            expect('Que exista un producto asociado a ese id de categoria', $model->attributes['idCategoria']=='1')->true();

        });
    }


    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
             'producto' => [
                'class' => ProductoFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/producto.php'
            ],
        ];
    }
}
