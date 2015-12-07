<?php

namespace backend\filtros;

use yii\db\ActiveRecord;
use yii\base\Behavior;
use Yii;
use yii\base\ActionFilter;

class AdminControl extends ActionFilter
{
	public function beforeAction($action)
	{
		//var_dump();
		if(Yii::$app->session['admin'] != null) 
		{
			return true;
		}
		else 
		{
			Yii::$app->getResponse()->redirect(['admin/login']);
		}
	}
}
