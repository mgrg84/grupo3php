<?php

namespace app\modules\v1\filters;

use yii\filters\auth\AuthMethod;
use app\modules\v1\controllers\TokenValidador;

class HttpPostAuth extends AuthMethod
{
    /**
     * @see yii\filters\auth\HttpBasicAuth
     */
    public $auth;

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $token = $request->post('token');        
        if( !$token ) {
            $token = $request->get('token');
        }
        
        if( TokenValidador::validarToken($token) )
        	return true;
        
        return null;
    }
}