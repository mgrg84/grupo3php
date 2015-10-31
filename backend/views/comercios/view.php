<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comercio */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comercios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comercio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre:ntext',
            'ubicacion:ntext',
             [                      // the owner name of the model
            'label' => Yii::t('app', 'Prioridad'),
            'value' => $model->prioridad == 1 ? Yii::t('app', "Baja") : ($model->prioridad == 2 ? Yii::t('app', "Media") : Yii::t('app', "Alta")),
            ],
            'horario_desde:ntext',
            'horario_hasta:ntext',
            [                      // the owner name of the model
            'label' => Yii::t('app','Lunes'),
            'value' => $model->lunes == 1 ? "Si" : "No",
            ],
            [                      // the owner name of the model
            'label' => Yii::t('app','Martes'),
            'value' => $model->martes == 1 ? "Si" : "No",
            ],
            [                      // the owner name of the model
            'label' => Yii::t('app','Miercoles'),
            'value' => $model->miercoles == 1 ? "Si" : "No",
            ],
            [                      // the owner name of the model
            'label' => Yii::t('app','Jueves'),
            'value' => $model->jueves == 1 ? "Si" : "No",
            ],
            [                      // the owner name of the model
            'label' => Yii::t('app','Viernes'),
            'value' => $model->viernes == 1 ? "Si" : "No",
            ],
            [                      // the owner name of the model
            'label' => Yii::t('app','Sabado'),
            'value' => $model->sabado == 1 ? "Si" : "No",
            ],
            [                      // the owner name of the model
            'label' => Yii::t('app','Domingo'),
            'value' => $model->domingo == 1 ? "Si" : "No",
            ]
        ],
    ]) ?>

</div>
