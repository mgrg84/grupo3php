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
        if( !AdminControl::esAdmin(Yii::$app->user->identity->username) )
            return $this->redirect(Yii::$app->urlManager->createUrl('./../../frontend/web/'));

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
        if( !AdminControl::esAdmin(Yii::$app->user->identity->username) )
            return $this->redirect(Yii::$app->urlManager->createUrl('./../../frontend/web/'));

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
        if( !AdminControl::esAdmin(Yii::$app->user->identity->username) )
            return $this->redirect(Yii::$app->urlManager->createUrl('./../../frontend/web/'));

        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
        if( !AdminControl::esAdmin(Yii::$app->user->identity->username) )
            return $this->redirect(Yii::$app->urlManager->createUrl('./../../frontend/web/'));

        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        
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
        if( !AdminControl::esAdmin(Yii::$app->user->identity->username) )
            return $this->redirect(Yii::$app->urlManager->createUrl('./../../frontend/web/'));

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
        if( !AdminControl::esAdmin(Yii::$app->user->identity->username) )
            return $this->redirect(Yii::$app->urlManager->createUrl('./../../frontend/web/'));
        
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
