<?php

/*namespace tests\codeception\common\unit\models;

use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;
use common\models\User;
use tests\codeception\common\fixtures\UserFixture;

/**
 * Login form test
 */
/*class UserTest extends DbTestCase
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
        $model = new User([
            
            'username' => 'Marianela',
            'email' => 'mgrg84@gmail.com',
            'password_hash' => '123',
            'auth_key' => '123',
            'confirmed_at' => '123',
            'unconfirmed_email' => '1',
            'blocked_at' => '123',
            'registration_ip' => '123',
            'created_at' => '123',
            'updated_at' => '123',
            'flags' => '123',
            'ubicacionDomicilio' => 'Mi domicilio es este',
        ]);

        $model->save();

        $this->specify('Que se haya creado un Usuario', function () use ($model){
            
            expect('Que exista un usuario con el nombre creado', $model->attributes['username']=='Marianela')->true();

            expect('Que exista una email con el nombre creado', $model->attributes['email']=='mgrg84@gmail.com')->true();

            expect('Que exista una password_hash con el nombre creado', $model->attributes['password_hash']=='123')->true();

            expect('Que exista una auth_key con el nombre creado', $model->attributes['auth_key']=='123')->true();

            expect('Que exista una confirmed_at con el nombre creado', $model->attributes['confirmed_at']=='123')->true();


            expect('Que exista una unconfirmed_email con el nombre creado', $model->attributes['unconfirmed_email']=='123')->true();

            expect('Que exista una blocked_at con el nombre creado', $model->attributes['blocked_at']=='123')->true();

            expect('Que exista una registration_ip con el nombre creado', $model->attributes['registration_ip']=='123')->true();

            expect('Que exista una created_at con el nombre creado', $model->attributes['created_at']=='123')->true();

            expect('Que exista una email con el nombre creado', $model->attributes['updated_at']=='mgrg84@gmail.com')->true();

            expect('Que exista una updated_at con el nombre creado', $model->attributes['flags']=='123')->true();

            expect('Que exista una ubicacionDomicilio con el nombre creado', $model->attributes['ubicacionDomicilio']=='Mi domicilio es este')->true();



        });
    }


    
    public function fixtures()
    {
        return [
             'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/user.php'
            ],
        ];
    }
}*/
