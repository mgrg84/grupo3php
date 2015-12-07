<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use app\modules\v1\models\Pedido;
use app\modules\v1\controllers\TokenValidador;
use app\modules\v1\filters\HttpPostAuth;
use Yii;

class PedidoController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\Pedido';
	/*
	public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpPostAuth::className(),
        ];

        return $behaviors;
    }
	*/
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['delete'], $actions['update'], $actions['create']);

		return $actions;
	}

	public function actionCreate() {
		$POST = Yii::$app->request->post();
		$pedido = [];
		$errores = [];
		return ['post'=>$POST, 'hash'=>TokenValidador::validarDatos($POST)];
		foreach ($POST['datos'] as $key => $value) {
			$pedido[$key] = $value;
		}
		
		$pedido['idUsuario'] = TokenValidador::validarToken($POST['token']);
		$pedido['fecha'] = date('Y-m-d');

		if( !isset($pedido['idComercio']) )
			$errores['idComercio'] = "Debe seleccionar un comercio.";

		if( !isset($pedido['idProducto']) )
			$errores['idProducto'] = "Debe seleccionar un producto.";

		if( !isset($pedido['cantidad']) || !is_numeric($pedido['cantidad']) || ((int)$pedido['cantidad'] <= 0) )
			$errores['cantidad'] = "El valor ingresado no es valido.";

		$POST['Pedido'] = $pedido;
		$model = new Pedido();

		if( !sizeof($errores) ) {
	        if ( $model->load($POST) && $model->save()) {
	        	$url = Yii::$app->request->baseUrl;
        		$url = substr($url, 0, strlen($url) - 3) . "mobile/web/";
	            return ['status'=>'OK', 'url'=>$url];
	        } else {
	        	$errores['error'] = "Hubo un problema al procesar su pedido! Intentelo nuevamente.";
	        }
        }
        return ['status'=>'NOT_OK', 'mensajes'=>$errores];
	}
	
}