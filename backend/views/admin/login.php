<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>

<form method="POST" action="/login">
  <div class="form-group">
    <label for="nickname"><?php Yii::t('app', 'Nickname'); ?></label>
    <input type="text" class="form-control" id="nickname" placeholder="Nombre de usuario" name="nickname">
  </div>
  <div class="form-group">
    <label for="password"><?php Yii::t('app', 'Password'); ?></label>
    <input type="password" class="form-control" id="password" placeholder="<?php Yii::t('app', 'Password'); ?>" name="password">
  </div>
  <button type="submit" class="btn btn-default"><?php Yii::t('app', 'Submit'); ?></button>
</form>

