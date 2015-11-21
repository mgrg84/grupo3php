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

    <?php $form = ActiveForm::begin(array('options' => array('id' => 'comercioForm'))); ?>

    <?= $form->field($model, 'idUsuario')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'username'))->label(Yii::t('app', 'Usuario'))?>
    <?= $form->field($model, 'fecha')->widget(DateControl::classname())?>

    <div id="comercios"></div>
	
	<div id="map_canvas" style="width:100%;height:400px;"></div>
    <div id="control_panel">
    <div id="directions_panel" style="margin:20px;background-color:#FFEE77;"></div>
    </div>
    <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
    </script> 
    <script type="text/javascript">
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
					if($("#userLat").val() != null)
					{
						var userLat = $("#userLat").val();
						var userLng = $("#userLng").val();
						var userLocation = new google.maps.LatLng(userLat, userLng);
						
						$('input[type="checkbox"]').change(function() {
							calcRoute(userLocation);
						});
						calcRoute(userLocation);
					}
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
  
  function calcRoute(userLocation) 
  {
	//Clean current routes
	directionsDisplay.setDirections({routes: []});
	
	
	//Obtener ubicacion de comercios
	var waypoints = [];
	var marketChecks = $('input[type="checkbox"][id^="comLoc"]:checked');
	marketChecks.each(function() {
		var loc = $(this).attr("ubicacion")
		waypoints.push({ 
			location: new google.maps.LatLng(loc.split(";")[0], loc.split(";")[1]),
			stopover:false
		});
	});


	
    var request = {
        origin: userLocation,
        destination: userLocation,
        waypoints: waypoints,
        optimizeWaypoints: true,
        travelMode: google.maps.DirectionsTravelMode.WALKING
    };
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
        var route = response.routes[0];
        var summaryPanel = document.getElementById("directions_panel");
        summaryPanel.innerHTML = "";
        // For each route, display summary information.
        for (var i = 0; i < route.legs.length; i++) {
          var routeSegment = i + 1;
          summaryPanel.innerHTML += "<b>Detalles: </b><br />";
          summaryPanel.innerHTML += "Origen: " + route.legs[i].start_address + "<br />" ;
          summaryPanel.innerHTML += "Distancia: " + route.legs[i].distance.text + "<br />";
		  summaryPanel.innerHTML += "Tiempo aprox: " + Math.round((route.legs[i].duration.value + (waypoints.length * 1800)) / 3600) + " <?= Yii::t('app', 'horas') ?>";
        }
      } else {
        alert("directions response "+status);
      }
    });
  }
</script>

