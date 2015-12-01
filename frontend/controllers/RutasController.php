<?php

namespace frontend\controllers;	

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
