<?php

//use kartik-v\datecontrol\Module;

return [

    'language' => 'es-UY',//'es-UY', ver si tengo que dejar es-UY --- en-US es por defecto siempre


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

        //IDIOMAS
        'i18n' => [
                            'translations' => [
                                '*' => [
                                    'class' => 'yii\i18n\PhpMessageSource',
                                    'basePath' => '@common/messages',
                                ],
                            ],
                        ],

                        // fin de idiomas

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
    
    // 'datecontrol' =>  [
    //     'class' => 'kartik-v\datecontrol\Module',

    //     // format settings for displaying each date attribute (ICU format example)
    //     'displaySettings' => [
    //         Module::FORMAT_DATE => 'dd-MM-yyyy',
    //         Module::FORMAT_TIME => 'HH:mm:ss a',
    //         Module::FORMAT_DATETIME => 'dd-MM-yyyy HH:mm:ss a', 
    //     ],

    //     // format settings for saving each date attribute (PHP format example)
    //     'saveSettings' => [
    //         Module::FORMAT_DATE => 'php:Y-M-d', // saves as unix timestamp
    //         Module::FORMAT_TIME => 'php:H:i:s',
    //         Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
    //     ],

    //     // set your display timezone
    //     //'displayTimezone' => 'Asia/Kolkata',

    //     // set your timezone for date saved to db
    //     //'saveTimezone' => 'UTC',

    //     // automatically use kartik\widgets for each of the above formats
    //     'autoWidget' => true,

    //     // use ajax conversion for processing dates from display format to save format.
    //     'ajaxConversion' => false,

    //     // default settings for each widget from kartik\widgets used when autoWidget is true
    //     'autoWidgetSettings' => [
    //         Module::FORMAT_DATE => ['type'=>2, 'pluginOptions'=>['autoclose'=>true]], // example
    //         Module::FORMAT_DATETIME => [], // setup if needed
    //         Module::FORMAT_TIME => [], // setup if needed
    //     ],

    //     // custom widget settings that will be used to render the date input instead of kartik\widgets,
    //     // this will be used when autoWidget is set to false at module or widget level.
    //     'widgetSettings' => [
    //         Module::FORMAT_DATE => [
    //             'class' => 'yii\jui\DatePicker', // example
    //             'options' => [
    //                 'dateFormat' => 'php:Y-M-d',
    //                 'options' => ['class'=>'form-control'],
    //             ]
    //         ]
    //     ]
    //     // other settings
    // ]






    ],
    // FIN de módulo para la gestion de usuarios


    
];
