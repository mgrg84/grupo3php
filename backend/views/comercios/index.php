<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comercios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comercio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Comercio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre:ntext',
            'ubicacion:ntext',
            'prioridad',
            'horarioAtencion:ntext',
            // 'lunes',
            // 'martes',
            // 'miercoles',
            // 'jueves',
            // 'viernes',
            // 'sabado',
            // 'domingo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
