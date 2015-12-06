<?php

namespace app\modules\v1\controllers;

use Yii;

class TokenValidador 
{
	/**
     * Busca el token dado en la tabla tokens, si existe devuelve el id
     * del usuario correspondiente a ese token, si no existe devielve false
     * @param String $token, el token a buscar
     * @return false si no existe, el id del usuario si existe
     */
	public static function validarToken($token) 
    {
        $connection = Yii::$app->db;
        $connection->open();
        $command = $connection->createCommand('SELECT * FROM token WHERE code=:token');
        $command->bindValue(':token', $token);
        $tokenList = $command->query();
        $count = $tokenList->count();

        if($count == 0) {
            return false;
        } else {
            return $tokenList->read()['user_id'];
        }
    }
    /**
     * Valida los datos enviadoes por POST, comparando el hash recivido con
     * el creado ordenando los datos de acuerdo al algoritmo elegído. Controla
     * que el timestamp no sea mayor a $TIMEOUT segundos viejo, y que el token
     * sea valido segun funcion validarToken().
     * @param $POST El post enviado por la peticion
     * @return false si hay algun error, el id del usuario correspondiente al token
     * si anda todo bien.
     */
    public static function validarDatos($POST) 
    {
        $TIMEOUT = 60;
        if( !isset($POST['token']) || !isset($POST['timestamp'])
            || !isset($POST['key']) || !isset($POST['datos']) || !is_array($POST['datos']) )
            return false;
        
        $id = TokenValidador::validarToken($POST['token']);
        
        if( !$id )
            return false;

        $time = time();
        
        if ( ($time < $POST['timestamp']) || ($time - $POST['timestamp'] > $TIMEOUT) )
            return false;
        

        $KEY = $POST['key'];

        // ir a buscar la private key a la base!!
        $connection = Yii::$app->db;
        $connection->open();
        $command = $connection->createCommand('SELECT * FROM hmac_keys WHERE public_key=:KEY');
        $command->bindValue(':KEY', $KEY);
        $tokenList = $command->query();

        if( $tokenList->count() == 0 )
            return false;
        
        $PK = $tokenList->read()['private_key'];
        $datos = $POST['datos'];
        $hash = $POST['hash'];
        $timestamp = $POST['timestamp'];
        

        $impares = array();
        $pares = array();
        $keysPares = array();
        $keyImpares = array();

        ksort($datos);
        $i = 1;
        foreach ($datos as $key => $value) 
        {
            if( $i%2 ) 
            {
                array_push($pares, $value);
                array_push($keysPares, $key);
            } else {
                array_push($impares, $value);
                array_push($keyImpares, $key);
            }
            $i++;
        }

        $dataOrden = $KEY . implode($keyImpares) . implode($impares) . $PK 
            . implode($keysPares) . implode($pares) . $timestamp;

        if( $hash != hash("sha256", $dataOrden) )
            return false;
        
        return $id;
    }

}