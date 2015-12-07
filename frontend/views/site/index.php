<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div class="site-index">

    <div class="jumbotron">
        <p class="lead"><?=Yii::t('app', 'Bienvenido al sistema de relevamiento de comercios')?></p>


        <div id="output"></div>

        <form id="formTest" action="http://localhost/grupo3php/api/v1/users/test" method="post">
	        <input type="text" placeholder="param1" name="param1" />
	        <input type="text" placeholder="param2" name="param2" />
	        <input type="text" placeholder="param3" name="param3" />

			<input type="submit" value="Submit">
        </form>
		
    </div>
</div>
<script>
    $(document).ready(function ()
    {
        $("#formTest").on("submit", function(){
            var datos = {};
            $("#formTest input").each(function(){
              if( $(this).attr("name") != undefined )
                datos[$(this).attr("name")] = $(this).val();
            });
            console.log(datos);
            var timestamp = Math.round(+new Date()/1000);
            console.log(timestamp);
            var hash = getDataHash(datos, timestamp);
            console.log(hash);

            return false;
        });
    });
</script>