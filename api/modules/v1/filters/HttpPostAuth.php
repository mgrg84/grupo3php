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
        $POST = $request->post();
        if( sizeof($POST) > 0 ) {
            if( TokenValidador::validarDatos($POST) )
                return true;
        } else {
            if( TokenValidador::validarToken($request->get('token')) )
                return true;
        }
        
        return null;
    }
}