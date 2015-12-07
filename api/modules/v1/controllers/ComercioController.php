<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use app\modules\v1\filters\HttpPostAuth;
use app\modules\v1\models\Comercio;
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
		$GET = Yii::$app->request->get();

		$idUsuario = TokenValidador::validarToken($GET['token']);

		if( !Comercio::getRutaDeHoy($idUsuario) )
			return [];
		$comercios = Comercio::comerciosByIdUByFecha($idUsuario);

		return $comercios;
	}

}