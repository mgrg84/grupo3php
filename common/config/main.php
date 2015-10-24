<?php
return [
    'name' => 'Stock Manager',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //URL AMIGABLES
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,     
            // Disable r= routes

            'enablePrettyUrl' => true,     
            'rules' => array(
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),

        ],
        // FIN URL AMIGABLES
    ],
    'bootstrap' => ['gii'],


// módulo para la gestion de usuarios
'modules' => [
    'user' => [
        'class' => 'dektrium\user\Module',
        'enableUnconfirmedLogin' => true,
        'confirmWithin' => 21600,
        'cost' => 12,
        'admins' => ['admin']
    ],
    'gii' => [
        'class' => 'yii\gii\Module',
    ],
],
// FIN de módulo para la gestion de usuarios


    
];
