<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use dektrium\user\helpers\Password;
use app\modules\v1\models\User;
use app\modules\v1\filters\HttpPostAuth;
use Yii;

class UserController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\user';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpPostAuth::className(),
        ];

        return $behaviors;
    }

    public function actionToken(){
        
        $nick = Yii::$app->request->post()['username'];
        $pass = Yii::$app->request->post()['password'];

        $user = User::find()->where(['username' => $nick])->one();
        
        if($user) {
            $loginOk = Password::validate($pass, $user->password_hash);
        } else {
            $loginOk = false;
        }
        $token = "";

        if($loginOk) {
            $connection = Yii::$app->db;
            $connection->open();
            
            $command = $connection->createCommand('SELECT * FROM token WHERE user_id=:id');
            $command->bindValue(':id', $user->id);
            $tokenList = $command->query();
            $token = $tokenList->read()['code'];
        }
        
        $resultado = ['status'=>$loginOk, 'token'=>$token];

        return $resultado;
    }

    public function actionHola() {
        return  'hola';
    }

    public function actionTest() {
        $token = Yii::$app->request->post()['token'];

        return TokenValidador::validarToken($token);
    }

}