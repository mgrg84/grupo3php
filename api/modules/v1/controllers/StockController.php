<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use app\modules\v1\models\Stock;
use app\modules\v1\filters\HttpPostAuth;
use app\modules\v1\controllers\TokenValidador;
use Yii;

class StockController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\Stock';
	
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

		unset($actions['delete'], $actions['update'], $actions['create']);

		return $actions;
	}

	public function actionCreate() {
		$POST = Yii::$app->request->post();
		$stock = [];
		$errores = [];
		foreach ($POST['datos'] as $key => $value) {
			$stock[$key] = $value;
		}
		
		$stock['idUsuario'] = TokenValidador::validarToken($POST['token']);
		$stock['fecha'] = date('Y-m-d');

		if( !isset($stock['idComercio']) )
		$errores['idComercio'] = "Debe seleccionar un comercio.";

		if( !isset($stock['idProducto']) )
		$errores['idProducto'] = "Debe seleccionar un producto.";

		if( !isset($stock['cantidad']) || !is_numeric($stock['cantidad']) || ((int)$stock['cantidad'] <= 0) )
		$errores['cantidad'] = "El valor ingresado no es valido.";

		$POST['Stock'] = $stock;
		$model = new Stock();

		if( !sizeof($errores) ) {
			if ( $model->load($POST) && $model->save()) {
				$url = Yii::$app->request->baseUrl;
				$url = substr($url, 0, strlen($url) - 3) . "mobile/web/";
				return ['status'=>'OK', 'url'=>$url];
			} else {
				$errores['error'] = "Hubo un problema al procesar su stock! Intentelo nuevamente.";
			}
		}
		return ['status'=>'NOT_OK', 'mensajes'=>$errores];
	}
}