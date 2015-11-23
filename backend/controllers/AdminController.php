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
class AdminController extends Controller
{
    
    public function actionIndex()
    {
    	return $this->redirect(array('site/index'));
    }

    public function actionLogin() 
    {
    	$_POST = Yii::$app->request->post();
    	if( isset($_POST['nick']) && isset($_POST['pass']) ) {
    		if( ($_POST['nick'] == 'admin') && ($_POST['pass'] == 'admin') ) {
    			$_SESSION['admin'] = true;
    			//return $this->render('login', ['error' => true]);
    		} else {
    			//return $this->redirect(array('site/index'));
    		}
    	} else {
    		return $this->render('login');
    	}
    }

    public function actionLogout() {
    	if( isset($_SESSION['admin']))
    		unset($_SESSION['admin']);
    	return $this->redirect(array('admin/login'));
    }

}