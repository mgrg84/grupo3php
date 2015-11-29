<?php

namespace tests\codeception\common\unit\models;

use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;
use common\models\Comercio;
use tests\codeception\common\fixtures\ComercioFixture;

/**
 * Login form test
 */
class ComercioTest extends DbTestCase
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
        $model = new Comercio([
            'nombre' => 'Nuevo Comercio',
            'ubicacion' => 'Ubicacion' ,
            'prioridad' => '1',
            'lunes' => '1',
            'martes' => '1',
            'miercoles' => '1',
            'jueves' => '1',
            'viernes' => '1',
            'sabado' => '1',
            'domingo' => '1',
            'horario_desde' => '10',
            'horario_hasta' => '18',
            'ubicacion_descripcion' => 'Esta es la ubicacion'

        ]);

        $model->save();

        $this->specify('Que se haya creado un nuevo Comercio', function () use ($model){
            
            expect('Que exista un comercio con este nombre', $model->attributes['nombre']=='Nuevo Comercio')->true();


            expect('Que exista una ubicacion', $model->attributes['ubicacion']=='Ubicacion')->true();

            expect('Que exista una prioridad', $model->attributes['prioridad']=='1')->true();

            expect('Trabajo el lunes', $model->attributes['lunes']=='1')->true();

            expect('Trabajo el martes', $model->attributes['lunes']=='1')->true();

            expect('Trabajo el miercoles', $model->attributes['lunes']=='1')->true();

            expect('Trabajo el jueves', $model->attributes['lunes']=='1')->true();

            expect('Trabajo el viernes', $model->attributes['viernes']=='1')->true();

            expect('Trabajo el sabado', $model->attributes['sabado']=='1')->true();

            expect('Trabajo el domingo', $model->attributes['domingo']=='1')->true();

            expect('horario_desde', $model->attributes['horario_desde']=='10')->true();

            expect('horario_hasta', $model->attributes['horario_hasta']=='18')->true();

            expect('ubicacion_descripcion', $model->attributes['ubicacion_descripcion']=='Esta es la ubicacion')->true();


        });
    }


    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
             'comercio' => [
                'class' => ComercioFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/comercio.php'
            ],
        ];
    }
}
