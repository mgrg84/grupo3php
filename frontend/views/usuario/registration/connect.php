<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\User $model
 * @var dektrium\user\models\Account $account
 */
$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
$baseUrl = Yii::$app->getUrlManager()->getBaseUrl();
$this->registerCssFile($baseUrl .'/css/jquery-ui.css');
$this->registerCssFile($baseUrl .'/css/maps.css');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <p>
                        <?= Yii::t('user', 'In order to finish your registration, we need you to enter following fields') ?>:
                    </p>
                </div>
                <?php $form = ActiveForm::begin([
                    'id' => 'connect-account-form',
                ]); ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'username') ?>

                <input type="hidden" value="" id="ubicacionDomicilio" name="ubicacionDomicilio" />

                <div class="form-group" style="height:350px; width:auto; padding-bottom:30px">
                    <label id="ubicacionLabel" class="control-label" for="pac-input">Ubicacion Domicilio:</label>
                    <input id="pac-input" class="controls" type="text" placeholder="Search Box" value=""/>
                    <div id="map"></div>
                </div>
                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

                <?= Html::submitButton(Yii::t('user', 'Continue'), ['class' => 'btn btn-success btn-block',
                'id' => 'registrar']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'If you already registered, sign in and connect this account on settings page'), ['/user/settings/networks']) ?>.
        </p>
    </div>
</div>

<script>
    $(document).ready(function ()
    {
    	$('#registrar').click(function (e)
        {
            e.preventDefault();
            var errors = new Array();
            if ( ($('#ubicacionDomicilio').val() == "") )
            {
                errors.push(['Debe ingresar una ubicacion', '#ubicacionLabel']);
            }
            if (errors.length > 0)
            {
                errors.forEach(function(error){
                    $(error[1]).parent().find(".help-block").remove();
                    $("<div class='help-block'>"+error[0]+"</div>").insertAfter(error[1]);
                    $(error[1]).parent().addClass("has-error");
                });
            } else {
                $("#connect-account-form").submit();
            }
           return false;
        });

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
            zoom: 10,
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
                $('#ubicacionDomicilio').val(markers[0].getPosition().lat() + ';' + markers[0].getPosition().lng());
               // $('#ubicacionDomicilio').val($('#pac-input').val())
            });
            map.fitBounds(bounds);
        });
        // [END region_getplaces]
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkBJbbLObz_qiBTkEgI-k3M2LkC08T7vg&libraries=places&callback=initAutocomplete" async="" defer=""></script>