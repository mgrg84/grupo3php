<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\TimePicker;

$baseUrl = Yii::$app->getUrlManager()->getBaseUrl();
$this->registerJsFile($baseUrl.'/assets/js/jquery.ptTimeSelect.js');
$this->registerCssFile($baseUrl .'/css/jquery.ptTimeSelect.css');
$this->registerCssFile($baseUrl .'/css/jquery-ui.css');
$this->registerCssFile($baseUrl .'/css/maps.css');

?>


<div class="comercio-form">

    <?php $form = ActiveForm::begin(array('options' => array('id' => 'comercioForm'))); ?>

    <?= $form->field($model, 'nombre')->textInput() ?>

    <input type="hidden" value="<?=$model->ubicacion?>" id="ubicacion" name="Comercio[ubicacion]" />

    <div class="form-group" style="height:350px; width:auto; padding-bottom:30px">
        <label class="control-label" for="pac-input">Ubicacion:</label>
        <div id="floating-panel">
            <input id="address" type="textbox" />
        </div>
        <div id="map"></div>
    </div>


    <?= $form->field($model, 'prioridad')->dropdownList(['1'=>Yii::t('app', 'Baja'), '2'=>Yii::t('app', 'Media'), '3'=>Yii::t('app', 'Alta')]); ?>

    <div class="form-group field-comercio-horario_desde required">
        <label class="control-label" for="comercio-horario_desde">Horario desde:</label>
        <input type="text" id="comercio-horario_desde" class="form-control" name="Comercio[horario_desde]" value="<?= $model->horario_desde?>" />
        <div class="help-block"></div>
    </div>

    <div class="form-group field-comercio-horario_hasta required">
        <label class="control-label" for="comercio-horario_hasta">Horario hasta:</label>
        <input type="text" id="comercio-horario_hasta" class="form-control" name="Comercio[horario_hasta]" value="<?= $model->horario_hasta?>" />
        <div class="help-block"></div>
    </div>

    <script type="text/javascript">
            $(document).ready(function () {
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
    $('#comercioForm').on('submit', function (e)
    {
        var errors = new Array();
        if ($('#ubicacion').val() == "")
        {
            errors.push('Debe indicar la ubicacion del comercio.');
        }
        if (!$('#comercio-lunes').is(':checked')
            && !$('#comercio-martes').is(':checked')
            && !$('#comercio-miercoles').is(':checked')
            && !$('#comercio-jueves').is(':checked')
            && !$('#comercio-viernes').is(':checked')
            && !$('#comercio-sabado').is(':checked')
            && !$('#comercio-domingo').is(':checked'))
        {
            errors.push('Debe seleccionar al menos un dia de recorrido.');
        }
        if ($('#comercio-horario_desde').val() == "" || $('#comercio-horario_hasta').val() == "")
        {
            errors.push('Debe ingresar datos de horarios');
        }
        if (errors.length > 0)
        {
            e.preventDefault();
            alert(errors.join('\n'));
        }
    });

    $(document).ready(function ()
    {
        $(window).keydown(function (event)
        {
            if (event.keyCode == 13)
            {
                event.preventDefault();
                return false;
            }
        });
    });

    function initMap()
    {
        //Create map object
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 8,
            center: {lat: -34.397, lng: 150.644}
        });

        //var options = {
        //    types: ['(cities)'],
        //    componentRestrictions: { country: "uy" }
        //};

        //var input = document.getElementById('address');
        //var autocomplete = new google.maps.places.Autocomplete(input, options);

        var geocoder = new google.maps.Geocoder();

        document
            .getElementById('address')
            .addEventListener('keyup', function (event)
            {
                if (event.keyCode === 13)
                {
                    geocodeAddress(geocoder, map);
                }
            })
        ;
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos)
    {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
    }

    function geocodeAddress(geocoder, resultsMap)
    {
        var address = document.getElementById('address').value;
        geocoder.geocode({ 'address': address }, function (results, status)
        {
            if (status === google.maps.GeocoderStatus.OK)
            {
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location
                });
                $('#ubicacion').val(marker.getPosition().lat() + ';' + marker.getPosition().lng());
            }
            else
            {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

</script>
<script src="  https://maps.googleapis.com/maps/api/js?key=AIzaSyAkBJbbLObz_qiBTkEgI-k3M2LkC08T7vg&signed_in=true&callback=initMap" async="" defer=""></script>

