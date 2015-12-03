<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use dektrium\user\helpers\Password;
use app\modules\v1\models\User;
use Yii;

class UserController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\user';

    public function actionLogin(){
        
        $nick = Yii::$app->request->post()['username'];
        $pass = Yii::$app->request->post()['password'];

        $user = User::find()->where(['username' => $nick])->one();
        
        if($user) {
            $loginOk = Password::validate($pass, $user->password_hash);
        } else {
            $loginOk = false;
        }
        
        $resultado = ['status'=>$loginOk];

        return $resultado;
        /**/
        //return [$nick, $pass, $user];
    }

    public function actionHola(){
        return  'hola';
    }
}