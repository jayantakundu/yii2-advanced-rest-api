<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-rest-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
	'gii' => [
	    'class' => 'yii\gii\Module',
	    'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'] // adjust this to your needs
	],
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ],
	'v2' => [
            'basePath' => '@app/modules/v2',
            'class' => 'api\modules\v2\Module'
        ]
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
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
                    'controller' => [ 'v1/country', 'v1/restaurant'],
                    //'prefix' => '/countries/<id:\\d+>',
                    //'pluralize'=>false,
                    'tokens' => [
		            '{id}' => '<id:\\d+>', 
                    ],
                    'patterns' => [
			    //'PUT' => 'create',
                            'GET' => 'index',
                            //'GET search' => 'search',
                            'GET <id>' => 'view',
			    'GET <id>/review' => 'review',
			    'GET <id>/gallery' => 'gallery',
			    'GET <id>/menu' => 'menu'
			],
                    /*'extraPatterns' => [
			    'GET test' => 'ss',
			]*/
                    
                ],
		        [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => ['v1/explore','v1/cms'],
                    'pluralize'=>false,
                            'tokens' => [
                            '{id}' => '<id:\\d+>',
                            ],
                            'patterns' => [
                    'GET' => 'index',
                                'GET {id}' => 'view',
                         ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v2/explore'],
                    'pluralize'=>false,
                    'patterns' => [
                        'GET' => 'index',
                    ],
                ],
             
            ],        
        ]
    ],
    'params' => $params,
];



