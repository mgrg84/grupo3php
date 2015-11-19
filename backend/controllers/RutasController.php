<?php

namespace backend\controllers;

use Yii;
use common\models\Ruta;
use common\models\User;
use common\models\Comercio;
use common\models\RutaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\Code\Helpers;

/**
 * rutasController implements the CRUD actions for Comercio model.
 */
class RutasController extends Controller
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

		$model->load(Yii::$app->request->post());
		
		if ($model->load(Yii::$app->request->post())) 
		{
			//PROCESS
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
	 * Get a markets given date and user.
	 * @return mixed
	 */
	public function actionMarkets($date, $userID)
	{
		$filteredMarkets = [];
		$user = User::findOne((int)$userID);
		
		var_dump($user);
		$day = date('l', strtotime($date));
		$filterDay = null;
		
		
		switch($day)
		{
			case "Monday": $filterDay = 'lunes';
				break;
			case 'Tuesday': $filterDay = 'martes';
				break;	
			case 'Wednesday': $filterDay = 'miercoles';
				break;
			case 'Thursday': $filterDay = 'jueves';
				break;
			case 'Friday': $filterDay = 'viernes';
				break;
			case 'Saturday': $filterDay = 'sabado';
				break;
			case 'Sunday': $filterDay = 'domingo';
				break;
		}
		
		if ($user != null)
		{
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
					$distance = $this->distance($userLocation[0], $userLocation[1], $comercioLocation[0], $comercioLocation[1], "M");
					if($distance <= Yii::$app->params['MaxUserRadius'] * 1000)
					{
						array_push($filteredMarkets, ['comercio'=> $comercio, 'distancia' => $distance]);
					}
				}
			}
		}
		return $this->renderPartial('_listadoComercios', [ 'comercios' => $filteredMarkets ] );
	}

	function Rad($x) 
	{
		return $x * pi()/ 180;
	}


	function distance($lat1, $lon1, $lat2, $lon2, $unit) {

		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") 
		{
			return ($miles * 1.609344);
		} 
		else if ($unit == "N") 
		{
			return ($miles * 0.8684);
		}
		else if ($unit == "M") 
		{
			return round($miles * 1.609344 * 1000);
		} 
		else 
		{
			return $miles;
		}
	}
	
	function GetDistance($p1Lat, $p1Lng, $p2Lat, $p2Lng) 
	{
		$R = 6378137; // Earth’s mean radius in meter
		$dLat = $this-> Rad($p2Lat - $p1Lat);
		$dLong = $this-> Rad($p2Lng - $p1Lng);
		$a =  sin($dLat / 2) * sin($dLat / 2) + cos($this-> Rad($p1Lat)) * cos($this-> Rad($p2Lat)) * sin($dLong / 2) * sin($dLong / 2);
		$c = 2 * atan2(bcsqrt($a), bcsqrt(1 - $a));
		$d = $R * $c;
		return $d; // returns the distance in meter
	}

	/**
	 * Deletes an existing ruta model.
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
