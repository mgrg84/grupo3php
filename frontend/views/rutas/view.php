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

	<input type="hidden" id="routeID" value="<?=$model->id?>"/>

    <?= DetailView::widget([
    	'model' => $model,
    	'attributes' => [
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
	
	<div id="map_canvas" style="width:100%;height:300px;"></div>
    <div id="control_panel">
    <div id="directions_panel" style="display:none;margin:20px;padding:10px;border-radius:20px;background-color:#FFEE77;"></div>
    </div>
    <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
    </script> 
	
</div>

<script>
	var hereMarker;
	var directionDisplay;
	var directionsService;
	var map;

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
		var lastmarketLoc;
		var routeID = $("#routeID").val();
		
		$.ajax({
			url: '<?php echo Yii::$app->params['apiBaseUrl']. 'v1/rutas/';?>' + routeID,
			type: 'get',
			success: function (data)
			{
				var userLoc = data['usuario']['ubicacionDomicilio'];
				var userLat = userLoc.split(";")[0];
				var userLng = userLoc.split(";")[1];
				
				if(userLat != null)
				{
					var userLocation = new google.maps.LatLng(userLat, userLng);
			
					var waypoints = [];
					var rutaComercios = data['rutaComercios'];
					
					if(rutaComercios.length > 0)
					{
						rutaComercios.forEach(function(rutaComercio, index)
						{
							var comercioLoc = rutaComercio['comercio']['ubicacion'];
							var formatedLoc = new google.maps.LatLng(comercioLoc.split(";")[0], comercioLoc.split(";")[1]);

							if(index < rutaComercios.length - 1)
							{
								waypoints.push({ 
									location: formatedLoc,
									stopover:true
								});
							}
							else //last waypoint
							{
								 lastmarketLoc = formatedLoc;
							}
						});
		
						var request = {
							origin: userLocation,
							destination: lastmarketLoc,
							waypoints: waypoints,
							optimizeWaypoints: false,
							travelMode: google.maps.DirectionsTravelMode.WALKING
						};
						directionsService.route(request, function(response, status) 
						{
							if (status == google.maps.DirectionsStatus.OK) 
							{
								directionsDisplay.setDirections(response);
							}
							else 
							{
								alert("Ocurrio un error en el calculo de rutas. Vuelva a intentarlo");
							}
						});
					}
					else 
					{
						alert("La ruta no tiene ningun comercio asignado");
					}
				}
				else 
				{
					alert("Ocurrio un error en el calculo de rutas. Vuelva a intentarlo");
				}
			}
		});
		
	}
	
	window.setInterval(function(){
		if(navigator.geolocation) 
		{
			browserSupportFlag = true;
			navigator.geolocation.getCurrentPosition(
				function(position) {
					initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
					
					if(hereMarker != null)
					{
						hereMarker.setMap(null);
					}
					
					hereMarker = new google.maps.Marker({
						position: initialLocation,
						map: map,
						title: 'Tu ubicacion'
					});

					
					//map.setCenter(initialLocation);
				}, function() {
					alert("No fue posible determinar su ubicacion.");
				}
			);
		}
		// Browser doesn't support Geolocation
		else 
		{
			browserSupportFlag = false;
			handleNoGeolocation(browserSupportFlag);
		}
	}, 2000);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkBJbbLObz_qiBTkEgI-k3M2LkC08T7vg&libraries=places&callback=initialize" async="" defer=""></script>