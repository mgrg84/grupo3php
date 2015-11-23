<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\Code\Helpers;

/* @var $this yii\web\View */
/* @var $model common\models\Comercio */

$this->title = "Ruta del ".date("d-M-y",  strtotime($model->fecha));
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
    			'value' => $model->usuario->username,
    		],
    		[
    			'attribute' => Yii::t('app', 'Fecha'),
    			'value' =>  date("d-M-y",  strtotime($model->fecha)),
			],
    		[                      // the owner name of the model
    			'label' => Yii::t('app','Comercios'),
    			'value' => implode(", ", array_map(create_function('$rutaComercios', 'return $rutaComercios->comercio->nombre;'), $model->rutaComercios)),
    		],
    	]
    ]); 
    ?>
	
	<div id="map_canvas" style="width:100%;height:350px;"></div>
    <div id="control_panel">
    <div id="directions_panel" style="display:none;margin:20px;padding:10px;border-radius:20px;background-color:#FFEE77;"></div>
    </div>
    <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
    </script> 
	
</div>

<script>
	var directionDisplay;
	var directionsService;
	var map;
	
	//$(document).ready(initialize());

	function initialize() {
		directionsService = new google.maps.DirectionsService();
	
		directionsDisplay = new google.maps.DirectionsRenderer();

		var montevideo = new google.maps.LatLng(-34.893869, -56.165039);
		var myOptions = {
			zoom: 8,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: montevideo
		}
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		directionsDisplay.setMap(map);
		calcRoute();
	}
  
	function calcRoute() 
	{
		//Clean current routes
		var summaryPanel = document.getElementById("directions_panel");
		summaryPanel.innerHTML = "";
		summaryPanel.style.display = 'none';
		directionsDisplay.setDirections({routes: []});
		//
		
		var userLoc = '<?= $model->usuario->ubicacionDomicilio?>';
		var userLat = userLoc.split(";")[0];
		var userLng = userLoc.split(";")[1];
	
		if(userLat != null)
		{
			var userLocation = new google.maps.LatLng(userLat, userLng);
			
			//Obtener ubicacion de comercios
			var waypoints = [];
			var comIds = [];
			var marketloc = 
			[
				<?php 
				foreach($model->rutaComercios as $rutaCom)
				{
					echo "'".$rutaCom->comercio->ubicacion."',";	
				}
				?>
			];
			//
			
			if( marketloc.length > 0)
			{
				 marketloc.forEach(function(entry) {
					waypoints.push({ 
						location: new google.maps.LatLng(entry.split(";")[0], entry.split(";")[1]),
						stopover:true
					});
				});
		
				var request = {
					origin: userLocation,
					destination: userLocation,
					waypoints: waypoints,
					optimizeWaypoints: false,
					travelMode: google.maps.DirectionsTravelMode.WALKING
				};
				directionsService.route(request, function(response, status) 
				{
					if (status == google.maps.DirectionsStatus.OK) 
					{
						directionsDisplay.setDirections(response);
						var route = response.routes[0];
			
						summaryPanel.innerHTML = "";
						// For each route, display summary information.
						summaryPanel.innerHTML += "<b>Detalles de recorrido: </b><br />";
						for (var i = 0; i < route.legs.length; i++)
						{
							if(route.legs.length - 1 == i)
							{
								//Do nothing
							}
							else
							{
								var routeSegment = i + 1;
								summaryPanel.innerHTML += "Desde: " + route.legs[i].start_address + "<br />" ;
								summaryPanel.innerHTML += "Hasta: " + route.legs[i].end_address + "<br />" ;
								summaryPanel.innerHTML += "Distancia: " + route.legs[i].distance.text + "<br />";
								summaryPanel.innerHTML += "Tiempo aprox: " + Math.round(((route.legs[i].duration.value + <?= Yii::$app->params['marketDelay'] ?>) / 3600) * 10) / 10 + " <?= Yii::t('app', 'horas') ?>  <br /><br />";
							}
						}
						summaryPanel.style.display = 'inline-block';
					}
					else 
					{
						alert("Ocurrio un error en el calculo de rutas. Vuelva a intentarlo");
					}
				});
			}
		}
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkBJbbLObz_qiBTkEgI-k3M2LkC08T7vg&libraries=places&callback=initialize" async="" defer=""></script>