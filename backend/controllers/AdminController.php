<?php

namespace backend\controllers;

use Yii;
use dektrium\user\models\User;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioController implements the CRUD actions for User model.
 */
class AdminController extends Controller
{
    public function actionIndex()
    {
    	return $this->redirect(array('site/index'));
    }
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionLogin() 
    {
    	$post = Yii::$app->request->post();
        $session = Yii::$app->session;
        
        $admin = $session['admin'];
        if( $session->isActive && isset($admin)) {
            return $this->redirect(array('home/'));
        }
    	if( isset($post['nickname']) && isset($post['password']) ) {
            if( ($post['nickname'] == 'admin') && ($post['password'] == 'admin') ) {
                if( !$session->isActive ) 
                    $session->open();

                $session['admin'] = true;
    			return $this->redirect(array('home/'));
            } else {
                return $this->render('login', ['error' => true]);
    		}
    	} else {
    		return $this->render('login');
    	}
    }

    public function actionLogout() {
        $session = Yii::$app->session;
        if( !$session->isActive ) 
    		unset($session['admin']);
    	return $this->redirect(array('admin/login'));
    }

}