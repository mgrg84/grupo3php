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
    <input type="hidden" value="<?=$model->ubicacion_descripcion?>" id="ubicacionH" name="Comercio[ubicacion_descripcion    ]" />

    <div class="form-group" style="height:350px; width:auto; padding-bottom:30px">
        <label class="control-label" for="pac-input">Ubicacion:</label>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box" value="<?=$model->ubicacion_descripcion?>"/>
        <div id="map"></div>
    </div>


    <?= $form->field($model, 'prioridad')->dropdownList(['1'=>Yii::t('app', 'Normal'), '2'=>Yii::t('app', 'Alta')]); ?>

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

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

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

    function initAutocomplete()
    {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -34.8912486, lng: -56.187161100000026 },
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function ()
        {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // [START region_getplaces]
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function ()
        {
            var places = searchBox.getPlaces();

            if (places.length == 0)
            {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function (marker)
            {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place)
            {
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };


                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport)
                {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else
                {
                    bounds.extend(place.geometry.location);
                }
                $('#ubicacion').val(markers[0].getPosition().lat() + ';' + markers[0].getPosition().lng());
                $('#ubicacionH').val($('#pac-input').val())
            });
            map.fitBounds(bounds);
        });
        // [END region_getplaces]
    }
</script>
<!--<script src="  https://maps.googleapis.com/maps/api/js?key=AIzaSyAkBJbbLObz_qiBTkEgI-k3M2LkC08T7vg&signed_in=true&callback=initMap" async="" defer=""></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkBJbbLObz_qiBTkEgI-k3M2LkC08T7vg&libraries=places&callback=initAutocomplete" async="" defer=""></script>
