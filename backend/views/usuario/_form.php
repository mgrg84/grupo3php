<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dektrium\user\models\User */
/* @var $form yii\widgets\ActiveForm */
$baseUrl = Yii::$app->getUrlManager()->getBaseUrl();
$this->registerJsFile($baseUrl.'/assets/js/jquery.ptTimeSelect.js');
$this->registerCssFile($baseUrl .'/css/jquery.ptTimeSelect.css');
$this->registerCssFile($baseUrl .'/css/jquery-ui.css');
$this->registerCssFile($baseUrl .'/css/maps.css');
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
            'id'                     => 'usuarioForm',

    ]); ?>

    <!-- Usar i18r -->
    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <input type="hidden" value="<?= $create ? '' : $model->ubicacionDomicilio ?>" id="ubicacionDomicilio" name="ubicacionDomicilio" />

    <div class="form-group" style="height:350px; width:auto; padding-bottom:30px">
        <label class="control-label" for="pac-input">Ubicacion Domicilio:</label>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box" value=""/>
        <div id="map"></div>
    </div>
    
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script>

    $('#usuarioForm').on('submit', function (e)
    {
        var errors = new Array();
        if ( ($('#ubicacionDomicilio').val() == "") )
        {
            errors.push('Debe indicar la ubicacion del usuario.');
        }
        if (errors.length > 0)
        {
            e.preventDefault();
            alert(errors.join('\n'));
        } else {
            $("#usuarioForm").submit();
        }
       // return false;
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
    <?php 

    $latLong = explode(";", $create ? '' : $model->ubicacionDomicilio); 
        if( sizeof($latLong) != 2 ) {
            $latLong = ["-34.8912486","-56.18716110000002"];
        }
    ?>
    function initAutocomplete()
    {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: <?= $latLong[0] ?>, lng: <?=$latLong[1] ?> },
            zoom: 17,
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
        var myLatlng = new google.maps.LatLng(<?= $latLong[0] ?>, <?=$latLong[1] ?>);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map
        });
        marker.setMap(map);
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
                $('#ubicacionDomicilio').val(markers[0].getPosition().lat() + ';' + markers[0].getPosition().lng());
               // $('#ubicacionDomicilio').val($('#pac-input').val())
            });
            map.fitBounds(bounds);
        });
        // [END region_getplaces]
    }
</script>
<!--<script src="  https://maps.googleapis.com/maps/api/js?key=AIzaSyAkBJbbLObz_qiBTkEgI-k3M2LkC08T7vg&signed_in=true&callback=initMap" async="" defer=""></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkBJbbLObz_qiBTkEgI-k3M2LkC08T7vg&libraries=places&callback=initAutocomplete" async="" defer=""></script>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Continue'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
