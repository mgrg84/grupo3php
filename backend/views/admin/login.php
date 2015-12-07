<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
	.error {
		padding: 20px;
		font-size: large;
		border-radius: 10px;
	}
</style>
<div class="col-md-4 col-md-offset-4">
	<h1>Login de Administrador</h1>

	<?php if(isset($error)) { ?>

	<div class="bg-danger error">
		<p>Error! Usuario o contraseña incorrectos.</p>
	</div>

	<?php } ?>
	<form method="POST" action="<?php echo Yii::$app->request->baseUrl. '/admin/login' ?>">
		<div class="form-group">
			<label for="nickname"><?php Yii::t('app', 'Nickname'); ?></label>
			<input type="text" class="form-control" id="nickname" placeholder="Nombre de usuario" name="nickname">
		</div>
		<div class="form-group">
			<label for="password"><?php Yii::t('app', 'Password'); ?></label>
			<input type="password" class="form-control" id="password" placeholder="<?php Yii::t('app', 'Password'); ?>" name="password">
		</div>
		<button type="submit" class="btn btn-default">LOGIN</button>
	</form>
</div>
