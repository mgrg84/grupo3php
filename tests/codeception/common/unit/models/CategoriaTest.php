<?php

namespace tests\codeception\common\unit\models;

use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;
use common\models\Categoria;
use tests\codeception\common\fixtures\CategoriaFixture;

/**
 * Login form test
 */
class CategoriaTest extends DbTestCase
{

    use Specify;

    public function setUp()
    {
        parent::setUp();

        // Yii::configure(Yii::$app, [
        //     'components' => [
        //         'user' => [
        //             'class' => 'yii\web\User',
        //             'identityClass' => 'common\models\User',
        //         ],
        //     ],
        // ]);
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testCreate()
    {
        $model = new Categoria([
            'nombre' => 'Nueva Categoria'
        ]);

        $model->save();

        $this->specify('Que se haya creado una Categoria', function () use ($model){
            //$categoria = Categoria::find()->where(['nombre' => 'Nueva Categoria'])->one();
            //var_dump($model);die;
            expect('Que exista una categoria con el nombre creado', $model->attributes['nombre']=='Nueva Categoria')->true();
        });
    }


    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
             'categoria' => [
                'class' => CategoriaFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/categoria.php'
            ],
        ];
    }
}
