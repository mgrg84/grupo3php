<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

class CountriesController extends ActiveController
{
    public $modelClass = 'backend\models\Country';
	
}