<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use backend\Code\Helpers;
use common\models\User;
use kartik\datecontrol\DateControl;
use yii\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ComercioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Recorridos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ruta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    	'filterModel' => $searchModel,
        'columns' => [
    		[
    			'attribute' => Yii::t('app', 'Fecha'),
    			'value' =>  function($model)
    			{
    				return date("d-M-y",  strtotime($model->fecha));
    			},
    			'filter' => DateControl::widget(['name'=>'RutaSearch[fecha]', 'displayFormat' => 'php:d-M-y', 'saveFormat' => 'yyyy-MM-dd']),
    			'format' => 'html',
    		],
    		[
    			'attribute' => Yii::t('app', 'Comercios'),
    			'value' => function($model)
					{
						$marketNames = array_map(create_function('$rutaComercios', 'return $rutaComercios->comercio->nombre;'), $model->rutaComercios);
    					return implode(", ", $marketNames);	
					},
    		],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>

</div>
