<?php

namespace tests\codeception\common\unit\models;

use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;
use common\models\Stock;
use tests\codeception\common\fixtures\StockFixture;

/**
 * Login form test
 */
class StockTest extends DbTestCase
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
        $model = new Stock([
             [
            'cantidad' => '1',
            'fecha' =>  '12-10-18',
            'idUsuario' => '2',
            'idProducto' =>  '1',
            'idComercio' => '1',
    ],
        ]);

        $model->save();

        $this->specify('Que se haya creado un Stock', function () use ($model){
            
            expect('Que exista una categoria con el nombre creado', $model->attributes['cantidad']=='1')->true();

            expect('Que exista una fecha  creado', $model->attributes['fecha']=='12-10-18')->true();

            expect('Que exista una usuario  creado', $model->attributes['idUsuario']=='2')->true();

            expect('Que exista una producto  creado', $model->attributes['idProducto']=='1')->true();

            expect('Que exista una comercio  creado', $model->attributes['idComercio']=='1')->true();


        });
    }


    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
             'stock' => [
                'class' => StockFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/stock.php'
            ],
        ];
    }
}
