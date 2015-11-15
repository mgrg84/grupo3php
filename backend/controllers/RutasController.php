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
        $user = User::findOne($userID);
        if ($user != null)
        {
            $userLocation = split(";", $user->ubicacionDomicilio);
            $comercios = Comercio::find()->all();
            foreach ($comercios as $comercio)
            {
                $comercioLocation = split(";", $comercio->ubicacion);
                $distance = $this->GetDistance($userLocation[0], $userLocation[1], $comercioLocation[0], $comercioLocation[1]);
        	    if($distance <= 10)
                {
                    array_push($filteredMarkets, $comercio);
                }
            }
        }
        return $this->renderPartial('_listadoComercios', null, false, true);
    }

    function Rad($x) 
    {
        return x * pi()/ 180;
    }

    function GetDistance($p1Lat, $p1Lng, $p2Lat, $p2Lng) 
    {
        $R = 6378137; // Earth’s mean radius in meter
        $dLat = Rad(p2Lat - p1Lat);
        $dLong = Rad(p2Lng - p1Lng);
        $a =  sin(dLat / 2) * sin(dLat / 2) + cos(Rad(p1Lat)) * cos(Rad(p2Lat)) * sin(dLong / 2) * sin(dLong / 2);
        $c = 2 * atan(bcsqrt(a), bcsqrt(1 - a));
        $d = R * c;
        return d; // returns the distance in meter
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
