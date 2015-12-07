<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use app\modules\v1\filters\HttpPostAuth;
use app\modules\v1\controllers\TokenValidador;
use app\modules\v1\models\Ruta;
use Yii;

class RutaController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\Ruta';
	
	public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpPostAuth::className(),
        ];

        return $behaviors;
    }

	public function actions()
	{
		$actions = parent::actions();

		// disable the "delete" and "create" actions
		unset($actions['delete'], $actions['create'], $actions['update']);

		return $actions;
	}

	public function actionRuta() {
		$GET = Yii::$app->request->get();

		$idUsuario = TokenValidador::validarToken($GET['token']);
		$ruta = Ruta::find()->where([
			'idUsuario' => $idUsuario,
			'fecha' => date('Y-m-d'),
		])->one();
		
        if( $ruta ) {
        	return [
        		'idRuta'=>$ruta->id
        	];
        } else {
        	return [];
        }

	}
}