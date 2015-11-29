<?php
 
$db     = require(__DIR__ . '/db.php');
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'api',
    // Need to get one level up:
	'basePath' => dirname(__DIR__),
	/*'aliases' => 
	[
		'commonModels' => 'common.models',
	],*/
    'bootstrap' => ['log'],
    'components' => [
		'user' => 
		[
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => true,
		],
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
                    'logFile' => '@app/runtime/logs/api.log',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => [
                        'v1/ruta', 
                        'v1/user'
                    ],
                ],
            ],
        ], 
        'db' => $db,
    ],
    'modules' => [
        'v1' => [
			'class' => 'app\modules\v1\Module'
        ],
    ],
    'params' => $params,
];
 
return $config;