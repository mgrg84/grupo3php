<?php

/* @var $this \yii\web\View */
/* @var $content string */

use mobile\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
<script>
    
    var username = cargarDeLocalStorage("username");
    var barra;
    console.log(username);
    if( username == "NOT_FOUND" ) {
        barra = $("<ul id='w1' class='navbar-nav navbar-right nav'>" +
                    "<li>" +
                        "<a href='/grupo3php/mobile/web/site/login'>Login</a>" +
                    "</li>" +
                "</ul>");
    } else {
        barra = $("<ul id='w1' class='navbar-nav navbar-right nav'>" +
                    "<li><a href='/grupo3php/mobile/web/site/ruta'>Recorridos</a></li>" +
                    "<li><a href='/grupo3php/mobile/web/site/pedido'>Pedido</a></li>" +
                    "<li><a id='logout' href='#' data-method='post'>Logout(" + username + ")</a></li>" +
                "</ul>");
    }

    $("#w1").remove();
    $("#w0-collapse").append(barra);

    $(document).ready(function(){
        $("#logout").click(function(){
            destruirEnLocalStorage("username");
            destruirEnLocalStorage("token");
            var home = cargarDeLocalStorage("home");
            destruirEnLocalStorage("home");
            window.location.replace(home);
            return false;
        });
    });0
</script>
</html>
<?php $this->endPage() ?>
