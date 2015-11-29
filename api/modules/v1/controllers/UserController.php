<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\user';
}