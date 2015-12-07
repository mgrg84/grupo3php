<?php

namespace frontend\controllers;

use Yii;
use common\models\Stock;
use common\models\Ruta;
use common\models\StockSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\filtros\AdminControl;

/**
 * StockController implements the CRUD actions for Stock model.
 */
class StockController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }

    /**
     * Creates a new Stock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Stock();

        if ($model->load(Yii::$app->request->post())) {
            $model2 = Stock::find()->where([
                'idProducto' => $model->idProducto,
                'idComercio' => $model->idComercio
            ])->one();
            if ($model2 != null) {
                $model2->cantidad = $model->cantidad;
                $model2->save();
            } else {
                $model->save();
            }
            return $this->render('create', ['model' => new Stock()]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'comercios' => $this->comerciosByIdUByFecha()
            ]);
        }
    }

    /**
     * Updates an existing Stock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Stock model.
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
     * Finds the Stock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stock::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function comerciosByIdUByFecha() {
        $ruta = Ruta::find()->where([
            'idUsuario' => Yii::$app->user->id,
            'fecha' => date('Y-m-d')
            ])->one();
        if ($ruta == null) {
            return array();
        }
        $rComercios = $ruta->getRutaComercios();
        $idComercios = array();
        foreach ($rComercios as $key => $value) {
            array_push($idComercios, $value['idComercio']);
        }
        return $comercios = Comercio::findAll([$idComercios]);
    }
}
