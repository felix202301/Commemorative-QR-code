<?php
// 这是系统自动生成的middleware定义文件
return [
    'alias' => [
        //开启加密
        'apiOpenEncrypt' => app\middleware\api\OpenEncrypt::class,
        //token验证
        'apiAuthToken' => app\middleware\api\AuthToken::class,
    ],
];
