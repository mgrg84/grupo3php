<?php

namespace backend\controllers;

use Yii;
use dektrium\user\models\User;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\filtros\AdminControl;
use dektrium\user\models\RegistrationForm;

/**
 * UsuarioController implements the CRUD actions for User model.
 */
class UsuarioController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Yii::createObject(RegistrationForm::className());

        
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            $domicilio = Yii::$app->request->post()['ubicacionDomicilio'];
            $nick = Yii::$app->request->post()['register-form']['username'];
            
            $connection = new \yii\db\Connection([
                'dsn' => 'mysql:host=localhost;dbname=grupo3php',
                'username' => 'root',
                'password' => 'root',
            ]);
            $connection->open();

            $command = $connection->createCommand("UPDATE user SET ubicacionDomicilio='".$domicilio."'WHERE username='".$nick."'");
            $command->execute();

            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //var_dump(Yii::$app->request->post());
        
        $model = $this->findModel($id);
        $model->scenario = 'update';
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $domicilio = Yii::$app->request->post()['ubicacionDomicilio'];
            $nick = Yii::$app->request->post()['User']['username'];
            
            $connection = new \yii\db\Connection([
                'dsn' => 'mysql:host=localhost;dbname=grupo3php',
                'username' => 'root',
                'password' => 'root',
            ]);
            $connection->open();

            $command = $connection->createCommand("UPDATE user SET ubicacionDomicilio='".$domicilio."'WHERE username='".$nick."'");
            $command->execute();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        /*
        */
        //var_dump(Yii::$app->request->post());

    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Setea el campo confirmed_at.
     * @param integer $id
     * @return la vista del usuario
     */
    public function actionConfirmar($id)
    {
       
        $model = $this->findModel($id);
        $model->confirm();

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
