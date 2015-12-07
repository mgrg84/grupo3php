<?php

use yii\helpers\Html;


$session = Yii::$app->session;
$admin = $session['admin'];
if(isset($admin)) {
	Yii::$app->getResponse()->redirect(array('home/'));
} else {
	Yii::$app->getResponse()->redirect(array('admin/login'));
}
?>