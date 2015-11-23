<?php
namespace app\components;

use Yii;
use yii\base\ActionFilter;

class ControlDeAcceso extends ActionFilter
{

    public function beforeAction($action)
    {
        return false;
    }

    public function afterAction($action, $result)
    {
    }

}