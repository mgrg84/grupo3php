<?php

namespace backend\controllers;

use Yii;
use dektrium\user\models\User;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\filtros\AdminControl;
/**
 * UsuarioController implements the CRUD actions for User model.
 */
class HomeController extends Controller
{
    public function actionIndex()
    {
    	return $this->render('index');
    }

}