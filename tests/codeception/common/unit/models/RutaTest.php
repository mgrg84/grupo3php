<?php

namespace tests\codeception\common\unit\models;

use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;
use common\models\Ruta;
use tests\codeception\common\fixtures\RutaFixture;

/**
 * Login form test
 */
class RutaTest extends DbTestCase
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
        $model = new Ruta([
            'fecha' => '2015-11-17',

        ]);

        $model->save();

        $this->specify('Que se haya creado una Ruta', function () use ($model){
            
            expect('Que exista una ruta con la fecha creada', $model->attributes['fecha']=='2015-11-17')->true();
        });
    }


    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
             'fecha' => [
                'class' => RutaFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/ruta.php'
            ],
        ];
    }
}
