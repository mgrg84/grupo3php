<?php

namespace backend\controllers;

use Yii;
use common\models\Ruta;
use common\models\User;
use common\models\Comercio;
use common\models\ComercioPedidos;
use common\models\Pedido;
use common\models\RutaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use backend\Code\Helpers;


class EstadisticasController extends Controller
{
	public function behaviors()
	{
		return [
			'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [	],
					],
				];
	}


	public function actionProductsalesbymarket($market)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Pedido::find()
			//->joinWith('comercio')
			//->groupBy('idComercio')
			//->select(['idComercio', 'SUM(cantidad) as cantidad', 'comercio.nombre as nombreComercio']),
			,'pagination' => false
		]);
		//var_dump($dataProvider);
		$a = Pedido::find()
			->joinWith('comercio')
			->groupBy('idComercio')
			->select(['idComercio', 'SUM(cantidad) as cantidad', 'comercio.nombre as nombreComercio'])
			//->innerJoin(['Comercio'], ['idComercio' => 'id'])
			//->select(['Comercio.nombre', 'cantidad'])
			->all()
		;
		//var_dump($a);
		return $this->render('ventasPorComercio', ['dataProvider' => $dataProvider	]);
	}
	
	public function actionSuccessroutesbyuser()
	{
		/*$dataProvider = new ActiveDataProvider([
			'query' => Country::find(),
			'pagination' => false
			]);
		
		return $this->render('pie', [
			'dataProvider' => $dataProvider
			]);*/
		return $this->render('cumplimientoRecorridos');
	}
	
	public function actionProductordersbymarket($dateFrom, $dateTo)
	{
		/*$dataProvider = new ActiveDataProvider([
			'query' => Country::find(),
			'pagination' => false
			]);*/
		
		return $this->render('pedidosComercios');
	}

	/**
	 * Lists all ruta models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}
	
	/**
	 * Finds the ruta model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ruta the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Ruta::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
