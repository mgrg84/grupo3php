<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model dektrium\user\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
            'username',
            'email:email',
            'password_hash',
            'auth_key',
            [
                'attribute' => 'confirmed_at',
                'value' => $model->confirmed_at != null ? date("d-m-Y",$model->confirmed_at) : 'Sin confirmar',
            ],
            'unconfirmed_email:email',
            'blocked_at',
            'registration_ip',
            [
                'attribute' => 'created_at',
                'value' => $model->created_at != null ? date("d-m-Y",$model->created_at) : 'Sin confirmar',
            ],
            [
                'attribute' => 'updated_at',
                'value' => $model->updated_at != null ? date("d-m-Y",$model->updated_at) : 'Sin confirmar',
            ],
            'flags',
            'ubicacionDomicilio:ntext',
        ],
    ]) ?>

</div>
