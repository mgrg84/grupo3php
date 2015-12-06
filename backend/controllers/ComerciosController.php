<?php

namespace backend\controllers;

use Yii;
use common\models\Comercio;
use common\models\ComercioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\Code\Helpers;
use backend\filtros\AdminControl;

/**
 * ComerciosController implements the CRUD actions for Comercio model.
 */
class ComerciosController extends Controller
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
			'access' => [
				'class' => AdminControl::className(),
			]
        ];
    }

    /**
     * Lists all Comercio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComercioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comercio model.
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
     * Creates a new Comercio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comercio();

        $model->load(Yii::$app->request->post());
        
        if ($model->load(Yii::$app->request->post())) 
        {
            $model->horario_desde = Helpers::FormatHours($model->horario_desde);
            $model->horario_hasta = Helpers::FormatHours($model->horario_hasta);
            if($model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else 
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

   
    /**
     * Updates an existing Comercio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) 
        {
            $model->horario_desde = Helpers::FormatHours($model->horario_desde);
            $model->horario_hasta = Helpers::FormatHours($model->horario_hasta);
            if($model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else 
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Comercio model.
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
     * Finds the Comercio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comercio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comercio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
