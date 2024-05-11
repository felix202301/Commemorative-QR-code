<?php
return [
    'jwt_config' => [
        'key' => 'abc',//
        'iss' => 'http://example.org',//签发者
        'aud' => 'http://example.com',//jwt所面向的用户
        'exp' => 86400 * 31,//过期时间
        'alg' => 'HS256',//算法
    ]
];
