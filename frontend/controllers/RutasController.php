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
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
/**
 * rutasController implements the CRUD actions for Ruta model.
 */
class RutasController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
						// deny all POST requests
					[
						'allow' => false,
						'verbs' => ['POST']
					],
					// allow authenticated users
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
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
		$dataProvider = new ActiveDataProvider([
			'query' =>  Ruta::find()
			->where('idUsuario ='.Yii::$app->user->id)
			,
			'pagination' => false
		]);

		return $this->render('index', [
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
