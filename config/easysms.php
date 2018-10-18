<?php

return [

    // HTTP 请求的超时时间（秒）
    'timeout' => env('ALIYUN_SMS_TIMEOUT', 5.0),

    // 默认发送配置
    'default' => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
            'aliyun',
        ],
    ],

    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'aliyun' => [
            'access_key_id' => env('ALIYUN_SMS_ACCESS_KEY_ID', ''),
            'access_key_secret' => env('ALIYUN_SMS_ACCESS_KEY_SECRET', ''),
            'sign_name' => env('ALIYUN_SMS_SIGN_NAME', ''),
        ],
        // ...
    ],

    // 使用短信模板 'SMS_001'
    'template' => env('ALIYUN_SMS_TEMPLATE', '')
];
