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
             
            'cantidad' => '41',
            'fecha' =>  '12-10-12',
            'idUsuario' => '1',
            'idProducto' =>  '2',
            'idComercio' => '1',
    
        ]);

        $model->save();

        $this->specify('Que se haya creado un Stock', function () use ($model){
            
            expect('Que exista una categoria con el nombre creado', $model->attributes['cantidad']=='41')->true();

            expect('Que exista una fecha  creado', $model->attributes['fecha']=='12-10-12')->true();

            expect('Que exista una usuario  creado', $model->attributes['idUsuario']=='1')->true();

            expect('Que exista una producto  creado', $model->attributes['idProducto']=='2')->true();

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
