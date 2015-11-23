<?php

namespace backend\filtros;

use Yii;
use yii\base\ActionFilter;

class AdminControl {

	private static $admins = ['admin', 'mierdo'];

	public static function esAdmin($nickname)
    {
    	if( in_array($nickname, self::$admins) ) {
    		return true;
    	}
        return false;
    }

    public static function loginAdmin($nick, $pass)
    {
    }

}
