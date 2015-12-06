<?php

namespace tests\codeception\common\unit\models;

use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;
use common\models\Pedido;
use tests\codeception\common\fixtures\PedidoFixture;

/**
 * Login form test
 */
class PedidoTest extends DbTestCase
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
        $model = new Pedido([
            'cantidad' => '5',
            'fecha' => '18-07-15',
            'idUsuario' => '1',
            'idProducto' => '1',
            'idComercio' => '1',
        ]);

        $model->save();

        $this->specify('Que se haya creado un Pedido', function () use ($model){
          
            expect('Que exista una categoria con cantidad', $model->attributes['cantidad']=='5')->true();

            expect('Que exista una categoria con fecha', $model->attributes['fecha']=='18-07-15')->true();

            expect('Que exista una categoria con este idUsuario', $model->attributes['idUsuario']=='1')->true();

            expect('Que exista una categoria con este idProducto', $model->attributes['idProducto']=='1')->true();

            expect('Que exista una categoria con este idComercio', $model->attributes['idComercio']=='1')->true();
        });
    }


    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
             'pedido' => [
                'class' => PedidoFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/pedido.php'
            ],
        ];
    }
}
