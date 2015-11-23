<?php

namespace backend\controllers;

use Yii;
use common\models\Ruta;
use common\models\User;
use common\models\Comercio;
use common\models\RutaComercios;
use common\models\RutaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\Code\Helpers;

/**
 * rutasController implements the CRUD actions for Ruta model.
 */
class RutasController extends Controller
{
	public function behaviors()
	{
		return [
			/*'pageCache' => [
				'class' => 'yii\filters\PageCache',
				'enabled' => false,
			],*/
			'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['post'],
						],
					],
				];
	}

	/**
	 * Lists all ruta models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new RutaSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			]);
	}

	/**
	 * Displays a single ruta model.
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
	 * Creates a new ruta model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Ruta();
		 
		if ($model->load(Yii::$app->request->post())) 
		{
			//PROCESS
			if($model->save())
			{
				$routeID = $model->id;
				$markets = split(";", Yii::$app->request->bodyParams['markets']);
				foreach($markets as $market)
				{
					$rutaComercio = new RutaComercios();
					$rutaComercio->idRuta = $routeID;
					$rutaComercio->idComercio = $market; 
					$rutaComercio->recorrido= 0;
					$rutaComercio->save();
				}
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
	 * Get a markets given date and user.
	 * @return mixed
	 */
	public function actionMarkets($date, $userID)
	{
		$filteredMarkets = [];
		$user = User::findOne((int)$userID);
		
		//var_dump($user);
		$filterDay = Helpers::GetSpanishDay($date);
		
		$userLocation = split(";", $user->ubicacionDomicilio);
		$comercios = Comercio::find()
			->where($filterDay.' = true ')
			->orderBy(['prioridad'=>SORT_DESC])
			->all()
		;
		foreach ($comercios as $comercio)
		{
			$comercioLocation = split(";", $comercio->ubicacion);
			if(count($userLocation) > 1 && count($comercioLocation) > 1)
			{
				$distance = Helpers::GetDistance($userLocation[0], $userLocation[1], $comercioLocation[0], $comercioLocation[1], "M");
				if($distance <= Yii::$app->params['MaxUserRadius'] * 1000)
				{
					array_push($filteredMarkets, ['comercio'=> $comercio, 'distancia' => $distance, 'ubicacionUsuario' => $userLocation]);
				}
			}
		}
		
		return $this->renderPartial('_listadoComercios', [ 'comercios' => $filteredMarkets ] );
	}

	/**
	 * Deletes an existing ruta model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$route = $this->findModel($id);
		$routeMarkets = $route->rutaComercios;
		foreach($routeMarkets as $routeMarket)
		{
			$routeMarket->delete();
		}
		$route->delete();
		return $this->redirect(['index']);
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