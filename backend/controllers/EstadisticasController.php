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
use backend\filtros\AdminControl;


class EstadisticasController extends Controller
{
	public function behaviors()
	{
		return [
			'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [	],
					],
			'access' => [
				'class' => AdminControl::className(),
				]
		];
	}


	public function actionProductsalesbymarket($marketId)
	{
		$markets = Comercio::find()->all();
		
		if($marketId == "")
		{
			$marketId = -1;
		}
		
		$dataProvider = new ActiveDataProvider([
			'query' => Pedido::find()
				->where('idComercio = '.$marketId)
				->joinWith('producto')
				->select(['idProducto', 'producto.nombre as nombreProducto', 'SUM(cantidad) as cantidad'])
				->groupBy('idProducto')
				->orderBy(['cantidad' => SORT_DESC]) 
			,
			'pagination' => false
		]);

		return $this->render('ventasPorComercio', ['dataProvider' => $dataProvider, 'model' => $markets, 'marketId' => $marketId]);
	}
	
	public function actionSuccessroutesbyuser()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => User::find(),
			'pagination' => false
			]);

		return $this->render('cumplimientoRecorridos', ['dataProvider' => $dataProvider	]);
	}
	
	public function actionProductordersbymarket($dateFrom, $dateTo)
	{
		$dateConditions = 'true';
		if($dateFrom != '')
		{
			$dateConditions = "fecha >= '".$dateFrom."'";
		}
		if($dateTo != '')
		{
			if($dateConditions != 'true')
			{
				$dateConditions = $dateConditions.' and ';	
			}
			$dateConditions = $dateConditions."fecha <= '".$dateTo."'";
		}
		$dataProvider = new ActiveDataProvider([
			'query' => Pedido::find()
			->where($dateConditions)
			->joinWith('comercio')
			->groupBy('idComercio')
			->select(['idComercio', 'SUM(cantidad) as cantidad', 'comercio.nombre as nombreComercio']),
			'pagination' => false
			]);

		return $this->render('pedidosComercios', ['dataProvider' => $dataProvider	]);
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
