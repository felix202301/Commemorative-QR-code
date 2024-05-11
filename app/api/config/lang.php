<?php
// +----------------------------------------------------------------------
// | 多语言设置
// +----------------------------------------------------------------------

return [
    // 默认语言
    'default_lang'    => env('lang.default_lang', 'zh-cn'),
    // 允许的语言列表
    'allow_lang_list' => [
        0 => 'zh-cn',//0中文
        1 => 'en-us',//1英文
        2 => 'zh-hk',//2中国香港
        3 => 'zh-tw',//3中国台湾
    ],
    // 多语言自动侦测变量名
    'detect_var'      => 'lang',
    // 是否使用Cookie记录
    'use_cookie'      => true,
    // 多语言cookie变量
    'cookie_var'      => 'think_lang',
    // 多语言header变量
    'header_var'      => 'think-lang',
    // 扩展语言包
    'extend_list'     => [
        'zh-cn'    => [
            app()->getBasePath() . 'api/lang/zh-cn.php',
        ],
        'en-us'    => [
            app()->getBasePath() . 'api/lang/en-us.php',
        ]
    ],
    // Accept-Language转义为对应语言包名称
    'accept_language' => [
        'zh-hans-cn' => 'zh-cn',
    ],
    // 是否支持语言分组
    'allow_group'     => false,
    'messages_list' => [
        'zh-cn'    => [
            app()->getBasePath() . 'api/lang/zh-cn/messages.php',
        ],
        'zh-tw'    => [
            app()->getBasePath() . 'api/lang/zh-tw/messages.php',
        ],
        'zh-hk'    => [
            app()->getBasePath() . 'api/lang/zh-hk/messages.php',
        ],
        'en-us'    => [
            app()->getBasePath() . 'api/lang/en-us/messages.php',
        ]

    ],
];