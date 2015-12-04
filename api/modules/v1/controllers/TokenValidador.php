<?php

namespace app\modules\v1\controllers;

use Yii;

class TokenValidador {
	
	public static function validarToken($token) {
        $connection = Yii::$app->db;
        $connection->open();
        $command = $connection->createCommand('SELECT * FROM token WHERE code=:token');
        $command->bindValue(':token', $token);
        $tokenList = $command->query();
        $count = $tokenList->count();

        if($count == 0) {
            return false;
        } else {
            return true;
        }
    }

}