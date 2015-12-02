<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;

class StockController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\Stock';
}