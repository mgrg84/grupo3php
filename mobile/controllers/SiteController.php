<?php
namespace mobile\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionLogout()
    {
        return $this->goHome();
    }

    public function actionRuta() {
        return $this->render('ruta');
    }

    public function actionStock() {
        return $this->render('stock');
    }

    public function actionPedido() {
        return $this->render('pedido');
    }

}
