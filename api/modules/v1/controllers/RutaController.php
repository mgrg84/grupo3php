<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;

class RutaController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\Ruta';
	
	public function actions()
	{
		$actions = parent::actions();

		// disable the "delete" and "create" actions
		unset($actions['delete'], $actions['create'], $actions['update']);

		return $actions;
	}
}