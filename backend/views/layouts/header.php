<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">


    <nav class="navbar navbar-default" role="navigation" style="margin-left: 0px;">

        <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#stkmngr-navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
		<?= Html::a('<span class="logo-mini">S.M</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>
    </div>


        <div class="collapse navbar-collapse"  id="stkmngr-navbar-collapse">

            <ul class="nav navbar-nav navbar-right">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <?= Html::a('Pedidos', ['/pedido/']) ?>
                </li>
                <li class="dropdown messages-menu">
                    <?= Html::a('Categorias', ['/categoria/']) ?>
                </li>
                <li class="dropdown messages-menu">
                    <?= Html::a('Productos', ['/producto/']) ?>
                </li>
                <li class="dropdown notifications-menu">
                    <?= Html::a('Comercios', ['/comercios/']) ?>
                </li>
                <li class="dropdown notifications-menu">
                    <?= Html::a('Recorridos', ['/rutas/']) ?>
                </li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Estadisticas <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li>
						<?= Html::a('Productos mas Vendidos', ['/estadisticas/productsalesbymarket?marketId=']) ?>
					</li>
					<li>
						<?= Html::a('Cumplimiento de Recorridos', ['/estadisticas/successroutesbyuser']) ?>
					</li>
					<li>
						<?= Html::a('Pedidos por comercio', ['/estadisticas/productordersbymarket?dateFrom=&dateTo=']) ?>
					</li>
				  </ul>
				</li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <?= Html::a('Usuarios', ['/usuario/']) ?>
                </li>
                <!-- User Account: style can be found in dropdown.less -->

            </ul>
        </div>
    </nav>
</header>
