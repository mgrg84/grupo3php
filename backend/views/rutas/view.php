<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\Code\Helpers;

/* @var $this yii\web\View */
/* @var $model common\models\Comercio */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Recorridos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comercio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
             [                      // the owner name of the model
            'label' => Yii::t('app', 'Usuario'),
            'value' => $model->Usuario->username,
            ],
            'fecha:datetime',
            [                      // the owner name of the model
            'label' => Yii::t('app','Comercios'),
            'value' => function ($model)
            {
                $result = [];
                foreach ($model->RutaComercios as $comercio)
                {
                	$result.array_push($comercio -> Comercio -> nombre);
                }
                return join(", ", $result);
                
            },
            ],
        ],
    ]) ?>

</div>
