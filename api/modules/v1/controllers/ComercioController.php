<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use app\modules\v1\filters\HttpPostAuth;
use Yii;

class ComercioController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\Comercio';
	
	public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpPostAuth::className(),
            'except' => ['token', 'view'],
        ];

        return $behaviors;
    }
	
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['delete'], $actions['update'], $actions['create']);

		return $actions;
	}

	public function actionDeldia() {
		$POST = Yii::$app->request->post();

		$idUsuario = TokenValidador::validarToken($POST['token']);
		
	}

}