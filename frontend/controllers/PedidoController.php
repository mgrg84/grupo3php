<?php

namespace frontend\controllers;

use Yii;
use common\models\Pedido;
use common\models\PedidoSearch;
use common\models\Ruta;
use common\models\RutaComercios;
use common\models\Comercio;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PedidoController implements the CRUD actions for Pedido model.
 */
class PedidoController extends Controller
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
     * Displays a single Pedido model.
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
     * Creates a new Pedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionIndex()
    {
        if (($this->getRutaDeHoy()) == null) {
            return $this->render('index');
        } else {
        $model = new Pedido();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('create', ['model' => $model = new Pedido(),
                'comercios' => $this->comerciosByIdUByFecha()]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'comercios' => $this->comerciosByIdUByFecha()
            ]);
        }
        }
    }

    /**
     * Updates an existing Pedido model.
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
     * Deletes an existing Pedido model.
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
     * Finds the Pedido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pedido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pedido::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getRutaDeHoy(){
        $ruta = Ruta::find()->where([
            'idUsuario' => Yii::$app->user->id,
            'fecha' => date('Y-m-d')
            ])->one();
        return $ruta;
    }

    protected function comerciosByIdUByFecha() {
        $ruta = $this->getRutaDeHoy();
        $rComercios = RutaComercios::find()->where([
            'idRuta' => $ruta->id
            ])->all();
        $idComercios = array();
        foreach ($rComercios as $key => $value) {
            array_push($idComercios, $value['idComercio']);
        }
        $comercios = Comercio::findAll($idComercios);
        
        return $comercios;
    }
}
