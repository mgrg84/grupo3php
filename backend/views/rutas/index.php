<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\Code\Helpers;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ComercioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Recorridos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ruta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Crear recorrido'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'fecha:datetime',
            [
                'attribute' => Yii::t('app', 'Usuario'),
                'value' => function($model) 
                {
                    return $model->Usuario->username;
                },
                //'filter' => Html::activeDropDownList($searchModel, 'prioridad', ['1'=>Yii::t('app', 'Baja'), '2'=>Yii::t('app', 'Media'), '3'=>Yii::t('app', 'Alta')], ['class'=>'form-control','prompt' => Yii::t('app','Seleccionar prioridad')]),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
