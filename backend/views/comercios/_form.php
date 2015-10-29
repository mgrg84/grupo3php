<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Comercio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comercio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput() ?>

    <div id='map' streetnumber='946' streetname='LAKE+DESTINY+RD'
         cityname='ALTAMONTE+SPRINGS' statecode='FL' zipcode='32714'
         zoom=18 width=500 height=300>
    </div>
    <?=  $form->field($model, 'ubicacion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'prioridad')->textInput() ?>

    <div class="form-group field-comercio-horario_desde required">
        <label class="control-label" for="comercio-horario_desde">Horario desde:</label>
        <input type="text" id="comercio-horario_desde" class="form-control" name="Comercio[horario_desde]" value="<?= $model->horario_desde?>"/>
        <div class="help-block"></div>
    </div>

    <div class="form-group field-comercio-horario_hasta required">
        <label class="control-label" for="comercio-horario_hasta">Horario hasta:</label>
        <input type="text" id="comercio-horario_hasta" class="form-control" name="Comercio[horario_hasta]" value="<?= $model->horario_hasta?>" />
        <div class="help-block"></div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('input[name="Comercio[horario_desde]"]').ptTimeSelect();
            $('input[name="Comercio[horario_hasta]"]').ptTimeSelect();
        });
    </script>

    <h3>Dias de recorrido:</h3>
    <?= $form->field($model, 'lunes')-> checkbox() ?>

    <?= $form->field($model, 'martes')-> checkbox() ?>

    <?= $form->field($model, 'miercoles')-> checkbox()?>

    <?= $form->field($model, 'jueves')-> checkbox() ?>

    <?= $form->field($model, 'viernes')-> checkbox() ?>

    <?= $form->field($model, 'sabado')-> checkbox() ?>

    <?= $form->field($model, 'domingo')-> checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$.fn.googlemap = function(){
    // author: Christian Salazar <christiansalazarh@gmail.com>
    var src='';
    $(this).each(function(){
    var z = $(this);
    var address = jQuery.trim(z.attr('streetnumber'))
        +'+'+jQuery.trim(z.attr('streetname'))
        +'+'+jQuery.trim(z.attr('cityname'))
        +'+'+jQuery.trim(z.attr('statecode'))
        +'+'+jQuery.trim(z.attr('zipcode'))
    ;
    src="https://maps.google.com/maps?"
        +"client=safari"
        +"&q="+address
        +"&oe=UTF-8&ie=UTF8&hq="
        +"&hnear="+address
        +"&gl=us"
        +"&z="+z.attr('zoom')
        +"&output=embed";
        z.html("<iframe src='"+src+"' width="+z.attr('width')+" height="
        +z.attr('height')+"></iframe>");
    });
    return src;
}
</script>
