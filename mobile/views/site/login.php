<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12">
        	<form id="login-form" action="" method="POST" role="form">
        		<legend><?= Yii::t('app', 'Login') ?></legend>
        	
        		<div class="form-group">
        			<label for="username"><?= Yii::t('app', 'Username') ?></label>
        			<input name="username" type="text" class="form-control" id="username" 
        				placeholder="<?= Yii::t('app', 'Username') ?>">
        		</div>

        		<div class="form-group">
        			<label for="password"><?= Yii::t('app', 'Password') ?></label>
        			<input name="password" type="password" class="form-control" id="password" 
        				placeholder="<?= Yii::t('app', 'Password') ?>">
        		</div>
        	
        		<button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Submit') ?></button>
        	</form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#login-form").on('submit', function(){
            var response = enviarFormularioPOST("login-form", handleResponse, "../../../api/v1/users/token");
            return false;
        });

        function handleResponse(data) {
            if( data.status == "OK") {
                guardarEnLocalStorage("token", data.token);
                guardarEnLocalStorage("username", data.username);
                guardarEnLocalStorage("home", data.url);
                window.location.replace(data.url);
            } else {
                console.log("Error!");
                console.log(data.mensajes);

                var errors = new Array();
                if ( data.mensajes.error != undefined )
                    errors.push([data.mensajes.error, '#login-form']);
                
                if( data.mensajes.username != undefined )
                    errors.push([data.mensajes.username, '#username']);

                if( data.mensajes.password != undefined )
                    errors.push([data.mensajes.password, '#password']);

                agregarErrores("#login-form", errors);
            }
        }

    });
</script>