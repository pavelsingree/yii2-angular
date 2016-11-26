<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules' => [
        'site' => [
            'class' => 'modules\site\Module',
        ],
        'cars' => [
            'class' => 'modules\cars\Module',
        ],
        'lease' => [
            'class' => 'modules\lease\Module',
        ],
        'seo' => [
            'class' => 'modules\seo\Module',
        ],
        'users' => [
            'class' => 'modules\users\Module',
        ],
        'zipdata' => [
            'class' => 'modules\zipdata\Module',
        ],
    ],
];
