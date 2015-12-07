<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Fill');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12">
        	<form id="form-pedido" action="../../../api/v1/stocks" method="POST" role="form">
        		<legend><?= Yii::t('app', 'Fill Stock') ?></legend>
        	
				<div class="form-group">
					<label class="control-label" for="producto"><?= Yii::t('app', 'Product') ?></label>
	        		<select id="producto" class="form-control" name="idProducto">
					</select>
				</div>
        		<div class="form-group">
        			<label class="control-label" for="cantidad"><?= Yii::t('app', 'Quantity') ?></label>
					<input id="cantidad" class="form-control" name="cantidad" type="text">
        		</div>
        		<div class="form-group">
        			<label class="control-label" for="comercio"><?= Yii::t('app', 'Store') ?></label>
        			<select id="comercio" class="form-control" name="idComercio">
					</select>
        		</div>

        		<button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Submit') ?></button>
        	</form>
        </div>
    </div>
</div>

<script>
	$(document).ready(function() {

		$.ajax({
			url: '../../../api/v1/productos?token=' + cargarDeLocalStorage('token'),
			type: 'get',
			success: function (data) {
				data.forEach(function(item, index){
					$("#producto").append(
						$("<option value='" + item.id + "'>" + item.nombre + "</option>")
					);
				});
			}
		});
		$.ajax({
			url: '../../../api/v1/comercios?token=' + cargarDeLocalStorage('token'),
			type: 'get',
			success: function (data) {
				data.forEach(function(item, index){
					$("#comercio").append(
						$("<option value='" + item.id + "'>" + item.nombre + "</option>")
					);
				});
			}
		});

		$("#form-pedido").on('submit', function(){

			enviarFormularioPOST("form-pedido", function(data){
				if( data.status == "OK") {
	                window.location.replace(data.url);
	            } else {
	                console.log("Error!");
	                console.log(data.mensajes);

	                var errors = new Array();
	                if ( data.mensajes.error != undefined )
	                    errors.push([data.mensajes.error, '#form-pedido']);
	                
	                if( data.mensajes.idComercio != undefined )
	                    errors.push([data.mensajes.idComercio, '#comercio']);

	                if( data.mensajes.idProducto != undefined )
	                    errors.push([data.mensajes.idProducto, '#producto']);

	                if( data.mensajes.cantidad != undefined )
	                    errors.push([data.mensajes.cantidad, '#cantidad']);

	                agregarErrores("#login-form", errors);
	            }
			});

			return false;
		});
		
	});
</script>