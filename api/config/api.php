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
			'identityClass' => 'dektrium\user\models\User',
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
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => [
                        'v1/ruta', 
                        'v1/pedido',   
                        'v1/stock',
                        'v1/user',
                    ],
                    'extraPatterns' => [
                        'GET hola' => 'hola', // 'xxxxx' refers to 'actionXxxxx'
                        'POST token' => 'token',
                        'POST test' => 'test',
                        'POST create' => 'create',
                    ],
                ],
            ],
        ], 
        'db' => $db,
    ],
    'modules' => [
        'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',
            'options' => [
                'token_param_name' => 'accessToken',
                'access_lifetime' => 3600 * 24,
            ],
            'storageMap' => [
                'user_credentials' => 'common\models\User',
            ],
            'grantTypes' => [
                'user_credentials' => [
                    'class' => 'OAuth2\GrantType\UserCredentials',
                ],
                'refresh_token' => [
                    'class' => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true
                ]
            ]
        ]
        'v1' => [
			'class' => 'app\modules\v1\Module'
        ],
    ],
    'params' => $params,
];
 
return $config;