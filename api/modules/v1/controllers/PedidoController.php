<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;

class PedidoController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\Pedido';
	
	public function actions()
	{
		$actions = parent::actions();

		// disable the "delete" and "create" actions
		unset($actions['delete'], $actions['update']);

		return $actions;
	}
}