<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div style='overflow-x:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            //'password_hash',
            'auth_key',
            [
                'attribute' => 'confirmed_at',
                'format'    => 'raw',
                'value'     => function ($model) {
                    if ($model->confirmed_at != null) {
                        return date("d-m-Y",$model->confirmed_at); 
                    } else {
                        return 'Sin Confirmar';
                    }
                },
            ],
            // 'unconfirmed_email:email',
            // 'blocked_at',
            // 'registration_ip',
            // 'created_at',
            // 'updated_at',
            // 'flags',
            // 'ubicacionDomicilio:ntext',
            ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{confirmar}',
                'buttons' => [
                    'confirmar' => function ($url,$model,$key) {
                            if(is_null($model->confirmed_at))
                                return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url);
                    },
                ],

            ],
            /*
            [
              'attribute' => 'Details',
              'format' => 'raw',
              'value' => 'pija',
            ]
            */
        ],
    ]); ?>

    </div>
</div>
