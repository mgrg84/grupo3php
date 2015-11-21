<?php
/*return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',


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
        // FIN URL AMIGABLES dentro de component



        ],
    ],
];


return [
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


    
];*/

$db     = require(__DIR__ . '/../../config/db.php');
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'api-app',
    'name' => 'TimeTracker',
    // Need to get one level up:
    'basePath' => dirname(__DIR__).'/..',

    'bootstrap' => ['log'],
    
    'components' => [
        'request' => [
            // Enable JSON Input:
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                     // Create API log in the standard log dir
                     // But in file 'api.log':
                    'logFile' => '@app/runtime/logs/api.log',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/project','v1/time']],

		/*AQUI VA ALGO ASI PARA LOS CONTROLADORES

		  'HEAD <apiv:v\d+>/<controller:\w+>'              => '<apiv>/<controller>/index',
                    'GET <apiv:v\d+>/<controller:\w+>'               => '<apiv>/<controller>/index',
                    'HEAD <apiv:v\d+>/<controller:\w+>/<id:(.)+>'    => '<apiv>/<controller>/view',
                    'GET <apiv:v\d+>/<controller:\w+>/<id:(.)+>'     => '<apiv>/<controller>/view',
                    'POST <apiv:v\d+>/<controller:\w+>/<id:(.)+>'    => '<apiv>/<controller>/create', 
                    'PUT <apiv:v\d+>/<controller:\w+>/<id:(.)+>'     => '<apiv>/<controller>/update',
                    'PATCH <apiv:v\d+>/<controller:\w+>/<id:(.)+>'   => '<apiv>/<controller>/update',
                    'DELETE <apiv:v\d+>/<controller:\w+>/<id:(.)+>'  => '<apiv>/<controller>/delete',

		*/





            ],
        ], 
        'db' => $db,
    ],
    'modules' => [
        'v1' => [
		'basePath' => '@app/modules/v1',
            //'class' => 'app\api\modules\v1\Module',
		'class' => 'api\modules\v1\Module',
        ],
    ],
    'params' => $params,
];

return $config;

