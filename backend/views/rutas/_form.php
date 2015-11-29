<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DatePicker;
use kartik\datecontrol\DateControl;
use common\models\User;
use yii\helpers\ArrayHelper;

$baseUrl = Yii::$app->getUrlManager()->getBaseUrl();
//$this->registerCssFile($baseUrl .'/css/jquery-ui.css');

?>


<div class="comercio-form">

    <?php $form = ActiveForm::begin(array('options' => array('id' => 'rutaForm'))); ?>

	<input type="hidden" name="markets" id="markets">
    <?= $form->field($model, 'idUsuario')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'username'))->label(Yii::t('app', 'Usuario'))?>
    <?= $form->field($model, 'fecha')->widget(DateControl::classname())?>

    <div id="comercios"></div>
	
	<div id="map_canvas" style="width:100%;height:350px;"></div>
    <div id="control_panel">
    <div id="directions_panel" style="display:none;margin:20px;padding:10px;border-radius:20px;background-color:#FFEE77;"></div>
    </div>
    <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
    </script> 

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

	
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkBJbbLObz_qiBTkEgI-k3M2LkC08T7vg&signed_in=true&callback=initialize"
 async defer></script>

<script>
	var directionDisplay;
	var directionsService;
	var map;

	$("#ruta-fecha-disp").on("change", loadMarkets);
	$("#ruta-idusuario").on("change", loadMarkets);
    
	$('#rutaForm').on('submit', function (e)
    {
        var errors = new Array();
        if ($('#markets').val() == "")
        {
            errors.push('Debe seleccionar al menos un comercio para el recorrido.');
        }
		if($("#ruta-fecha-disp").val() == "")
		{
			errors.push('Debe seleccionar una fecha para el recorrido.');
		}

        if (errors.length > 0)
        {
            e.preventDefault();
            alert(errors.join('\n'));
        }
    });
	
	function loadMarkets()
    {
		if($("#ruta-fecha-disp").val() == "")
		{
			alert('Debe ingresar una fecha.');
		}
		else
		{
			$.ajax({
				url: '<?php echo Yii::$app->request->baseUrl. '/rutas/markets' ?>',
				type: 'get',
				data: { date: $("#ruta-fecha-disp").val(), userID: $("#ruta-idusuario").val() },
				success: function (data)
				{
					$("#comercios").html(data);
					$('input[type="checkbox"]').change(function() {
						calcRoute();
					});
					calcRoute();
				}
			})
		}
    };


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
		//calcRoute();
	}
  
	function calcRoute() 
	{
		//Clean current routes
		$("#markets").val("");
		var summaryPanel = document.getElementById("directions_panel");
		summaryPanel.innerHTML = "";
		summaryPanel.style.display = 'none';
		directionsDisplay.setDirections({routes: []});
		//
		
		var userLat = $("#userLat").val();
		var userLng = $("#userLng").val();
	
		if($("#userLat").val() != null)
		{
			var userLocation = new google.maps.LatLng(userLat, userLng);
			//Obtener ubicacion de comercios
			var waypoints = [];
			var comIds = [];
			var marketChecks = $('input[type="checkbox"][id^="comID"]:checked');
			//
			
			if(marketChecks.length > 0)
			{
				marketChecks.each(function() {
					var loc = $(this).attr("ubicacion")
					waypoints.push({ 
						location: new google.maps.LatLng(loc.split(";")[0], loc.split(";")[1]),
						stopover:true
					});
					var checkID = $(this).attr("id"); 
					comIds.push(checkID.replace("comID", ""));
				});
		
				var request = {
					origin: userLocation,
					destination: userLocation,
					waypoints: waypoints,
					optimizeWaypoints: true,
					travelMode: google.maps.DirectionsTravelMode.WALKING
				};
				directionsService.route(request, function(response, status) {
					if (status == google.maps.DirectionsStatus.OK) 
					{
						directionsDisplay.setDirections(response);
						var route = response.routes[0];
			
						//Save markets to hidden input
						var orders = route.waypoint_order;
						var orderMarkets = ";";
						orders.forEach(function(element, index, array)
						{
							orderMarkets += comIds[element]+";";
						})
						$("#markets").val(orderMarkets);
			
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

