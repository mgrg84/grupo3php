<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use dektrium\user\helpers\Password;
use app\modules\v1\models\User;
use app\modules\v1\filters\HttpPostAuth;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use filsh\yii2\oauth2server\filters\auth\CompositeAuth;
use Yii;

class UserController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\user';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpPostAuth::className(),
            'except' => ['token', 'view'],
        ];

        return $behaviors;
    }
    
    public function actionToken(){
        
        $POST = Yii::$app->request->post();
        $token = ""; 
        $mensajes = [];
        $loginOk = "ERROR";

        if( isset($POST['datos']['username']) && isset($POST['datos']['password']) ) {

            $nick = $POST['datos']['username'];
            $pass = $POST['datos']['password'];

            if( $nick == "" )
                $mensajes["username"] = Yii::t('app', 'Username cant be blank.');

            if( $pass == "" )
                $mensajes["password"] = Yii::t('app', 'Password cant be blank.');

            if( ($nick != "") && ($pass != "") ) {
                $user = User::find()->where(['username' => $nick])->one();
                
                if($user && Password::validate($pass, $user->password_hash))
                    $loginOk = "OK";

                if($loginOk == "OK") {
                    $connection = Yii::$app->db;
                    $connection->open();
                    
                    $command = $connection->createCommand('SELECT * FROM token WHERE user_id=:id');
                    $command->bindValue(':id', $user->id);
                    $tokenList = $command->query();
                    $token = $tokenList->read()['code'];
                    $mensajes = "";
                } else {
                    $mensajes["error"] = Yii::t('app', 'Invalid Password or Username.');
                }
            }

        }
        // /grupo3php/api
        $url = Yii::$app->request->baseUrl;
        $url = substr($url, 0, strlen($url) - 3) . "mobile/web/";
        $resultado = [
            'status'=>$loginOk,
            'token'=>$token,
            'username' => $nick,
            'mensajes'=>$mensajes, 
            'url'=> $url,
        ];

        return $resultado;
    }

    public function actionHola() {
        return  'hola';
    }

    public function actionTest() {
        return "VIVA!";
    }

}
