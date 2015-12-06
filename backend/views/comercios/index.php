<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\Code\Helpers;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ComercioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Comercios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comercio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Comercio'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'nombre:ntext',
            'ubicacion_descripcion:ntext',
            [
                'attribute' => Yii::t('app', 'Prioridad'),
                'value' => function($model) 
                {
                    return Helpers::GetPriorityDescription($model->prioridad);
                },
    			'filter' => Html::activeDropDownList($searchModel, 'prioridad',  ['1'=>Yii::t('app', 'Normal'), '2'=>Yii::t('app', 'Alta')], ['class'=>'form-control','prompt' => Yii::t('app','Seleccionar prioridad')]),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
