<?php
return [
    // 文档标题
    'title' => 'API接口文档',
    // 文档描述
    'desc' => '',
    // 默认请求类型
    'default_method' => 'GET',
    // 允许跨域访问
    'allowCrossDomain' => false,
    // 设置可选版本
    'apps' => [
        [
            //
            'headers' => [
                [
                    'name' => 'X-Token',
                    'type' => 'string',
                    'require' => true,
                    'desc' => 'admin应用的全局请求头参数token',
                    'value' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJpYXQiOjE2NTA0MjEzMDUsIm5iZiI6MTY1MDQyMTMwNSwiZXhwIjoxNjUzMDk5NzA1LCJhZG1pbkluZm8iOnsiaWQiOjEsIm5hbWUiOiJcdThkODVcdTdlYTdcdTdiYTFcdTc0MDZcdTU0NTgiLCJhY2NvdW50IjoiMTc3ODg4ODk5OTkiLCJlbWFpbCI6IjE3Nzg4ODg5OTk5QHFxLmNvbSIsInN0YXR1cyI6MSwiaXNfc3VwZXIiOjEsImFkbWluX2lkIjowLCJsb2dpbl9pcCI6Mjg4Njg2MDgwMSwibG9naW5fdGltZSI6MTY1MDQyMTMwNSwiY3JlYXRlX3RpbWUiOiIyMDIyLTAzLTExIDA5OjUzOjM5IiwidXBkYXRlX3RpbWUiOiIyMDIyLTA0LTIwIDEwOjIxOjQ1IiwiZGVsZXRlX3RpbWUiOjB9fQ.HZ5JYDQTvNaimc1bhOh2L6vFcmlT0cG2vL18t2D9dgg',
                ],
            ],
            //应用的名称
            'title' => '管理后台',
            //应用的目录
            'path' => 'app\admin\controller',
            //应用的文件夹名称
            'folder' => 'admin',
            //多层应用配置
            'items' => [
                ['title' => '管理后台', 'path' => 'app\admin\controller', 'folder' => 'admin',
                    'groups' => [
                        ['title' => '登录', 'name' => 'login'],
                        //['title' => '后台管理', 'name' => 'backstage'],
                        //['title' => '漫画数据', 'name' => 'mangaData'],
                    ],
                ],
                ['title' => '后台管理目录', 'path' => 'app\admin\controller\backstage', 'folder' => 'backstage',
                    'groups' => [
                        //['title' => '登录', 'name' => 'login'],
                        ['title' => '后台管理', 'name' => 'backstage'],
                        //['title' => '漫画数据', 'name' => 'mangaData'],
                    ],
                ],
                ['title' => 'APP产品管理', 'path' => 'app\admin\controller\app_product', 'folder' => 'app_product',
                    'groups' => [
                        //['title' => '登录', 'name' => 'login'],
                        //['title' => '后台管理', 'name' => 'backstage'],
                        ['title' => 'APP产品管理', 'name' => 'app_product'],
                    ],
                ],
            ],
            //应用的控制器分组
            'groups' => [
                ['title' => '登录', 'name' => 'login'],
                ['title' => '后台管理', 'name' => 'backstage'],
                ['title' => 'APP产品管理', 'name' => 'app_product'],
                //['title' => '漫画数据', 'name' => 'mangaData'],
            ],
            //指定api文档解析的控制器
            // 'controllers'=>[
            //     'app\admin\controller\BaseDemo',
            //     'app\admin\controller\CrudDemo',
            // ],
            // 'parameters'=>[
            //     ['name'=>'abc','type'=>'string','desc'=>'admin应用的全局请求体参数abc'],
            // ],
        ],
        [
            'title' => 'web模块',
            'path' => 'app\web\controller',
            'folder' => 'web',
            'items' => [
                ['title' => 'V1.0', 'path' => 'app\demo\controller\v1', 'folder' => 'v1'],
                ['title' => 'V2.0', 'path' => 'app\demo\controller\v2', 'folder' => 'v2']
            ],

        ],
    ],
    // 自动生成url规则
    'auto_url' => [
        // 字母规则
        'letter_rule' => "lcfirst",
        // 多级路由分隔符
        'multistage_route_separator' => ".",
//        'auto_url' => [
//            'custom' => function ($class, $method) {
//                return "admin.php/" . str_replace('\\', '/', $class) . $method;
//            },
//        ],
    ],
    // 指定公共注释定义的文件地址
    'definitions' => "app\common\ApiDocDefinitions",
    // 缓存配置
    'cache' => [
        // 是否开启缓存
        'enable' => false,
    ],
    // 权限认证配置
    'auth' => [
        // 是否启用密码验证
        'enable' => false,
        // 全局访问密码
        'password' => "123456",
        // 密码加密盐
        'secret_key' => "apidoc#hg_code",
        // 有效期
        'expire' => 24 * 60 * 60
    ],
    // 统一的请求Header
    'headers' => [
//        ['name'=>'token','type'=>'string','require'=>true,'desc'=>'登录票据'],
    ],
    // 统一的请求参数Parameters
    'parameters' => [],
    // 统一的请求响应体
    'responses' => [
        ['name' => 'code', 'desc' => '代码', 'type' => 'int'],
        ['name' => 'message', 'desc' => '业务信息', 'type' => 'string'],
        ['name' => 'data', 'desc' => '业务数据', 'main' => true, 'type' => 'object'],
    ],
    // md文档
    'docs' => [],
    // 代码生成器配置 注意：是一个二维数组
    'generator' => [
        [
            // 标题
            'title' => '创建CRUD',
            // 是否启用
            'enable' => env('apiDoc.generator_enable', false),
            // 执行中间件，具体请查看下方中间件介绍
            'middleware' => [
                // \app\middleware\CreateCrudMiddleware::class
            ],
            // 生成器窗口的表单配置
            'form' => [
                // 表单显示列数
                'colspan' => 3,
                // 表单项字段配置
                'items' => [
                    [
                        // 表单项标题
                        'title' => '控制器标题',
                        // 字段名
                        'field' => 'controller_title',
                        // 输入类型，支持：input、select
                        'type' => 'input',
                    ],
                    [
                        // 表单项标题
                        'title' => '控制器命名空间',
                        // 字段名
                        'field' => 'controller_namespace',
                        // 输入类型，支持：input、select
                        'type' => 'select',
                        'value' => '${app[0].folder}',
                    ],
                ]
            ],
            // 文件生成配置，注意：是一个二维数组
            'files' => [
                [
                    // 生成文件的文件夹地址，或php文件地址
                    'path' => 'app\${app[0].folder}\controller',
                    // 生成文件的命名空间
                    'namespace' => 'app\${app[0].folder}\controller',
                    // 模板文件地址
                    'template' => 'extend/api_doc/controller.tpl',
                    // 名称
                    'name' => 'controller',
                    // 验证规则
                    'rules' => [
                        ['required' => true, 'message' => '请输入控制器文件名'],
                        ['pattern' => '^[A-Z]{1}([a-zA-Z0-9]|[._]){2,19}$', 'message' => '请输入正确的控制器文件名'],
                    ]
                ],
                //[
                //    'name' => 'service',
                //    'path' => 'app\common\service',
                //    'template' => 'private/apidoc/service.tpl',
                //],
                [
                    'name' => 'validate',
                    //'path' => 'app\common\validate',
                    'path' => 'app\${app[0].folder}\validate',
                    'template' => 'extend/api_doc/validate.tpl',
                ],
                //[
                //    'name' => 'cache',
                //    'path' => 'app\common\cache',
                //    'template' => 'private/apidoc/cache.tpl',
                //],
            ],
            // 数据表配置
//            'table' => [
//                // 可选的字段类型
//                'field_types' => [
//                    "int",
//                    "tinyint",
//                    "integer",
//                    "float",
//                    "decimal",
//                    "char",
//                    "varchar",
//                    "blob",
//                    "text",
//                    "point",
//                ],
//                // 数据表配置，注意：是一个二维数组，可定义多个数据表
//                'items' => [
//                    [
//                        // 表标题
//                        'title' => '主表',
//                        // 模型名验证规则
//                        'model_rules' => [
//                            ['pattern' => '^[A-Z]{1}([a-zA-Z0-9]|[._]){2,19}$', 'message' => '模型文件名错误，请输入大写字母开头的字母+数字，长度2-19的组合']
//                        ],
//                        // 表名验证规则
//                        'table_rules' => [
//                            ['pattern' => '^[a-z]{1}([a-z0-9]|[_]){2,19}$', 'message' => '表名错误，请输入小写字母开头的字母+数字+下划线，长度2-19的组合']
//                        ],
//                        // 显示的提示文本
//                        'desc' => '提示说明文本',
//                        // 生成模型的命名空间
//                        'namespace' => 'app\common\model',
//                        // 生成模型的文件夹地址
//                        'path' => "app\common\model",
//                        // 模板文件地址
//                        'template' => "private/apidoc/model.tpl",
//                        // 自定义配置列
//                        'columns' => [
//                            [
//                                'title' => '验证',
//                                'field' => 'check',
//                                'type' => 'select',
//                                'width' => 180,
//                                'props' => [
//                                    'placeholder' => '请输入',
//                                    'mode' => 'multiple',
//                                    'maxTagCount' => 1,
//                                    'options' => [
//                                        ['label' => '必填', 'value' => 'require', 'message' => '缺少必要参数{$item.field}'],
//                                        ['label' => '数字', 'value' => 'number', 'message' => '{$item.field}字段类型为数字'],
//                                        ['label' => '整数', 'value' => 'integer', 'message' => '{$item.field}为整数'],
//                                        ['label' => '布尔', 'value' => 'boolean', 'message' => '{$item.field}为布尔值'],
//                                    ],
//                                ],
//                            ],
//                            [
//                                'title' => '查询',
//                                'field' => 'query',
//                                'type' => 'checkbox',
//                                'width' => 60
//                            ],
//                            [
//                                'title' => '列表',
//                                'field' => 'list',
//                                'type' => 'checkbox',
//                                'width' => 60
//                            ],
//                            [
//                                'title' => '信息',
//                                'field' => 'info',
//                                'type' => 'checkbox',
//                                'width' => 60
//                            ],
//                            [
//                                'title' => '添加',
//                                'field' => 'add',
//                                'type' => 'checkbox',
//                                'width' => 60
//                            ],
//                            [
//                                'title' => '修改',
//                                'field' => 'edit',
//                                'type' => 'checkbox',
//                                'width' => 60
//                            ]
//                        ],
//                        // 默认字段
//                        'default_fields' => [
//                            [
//                                // 字段名
//                                'field' => 'id',
//                                // 字段注释
//                                'desc' => '主键id',
//                                // 字段类型
//                                'type' => 'int',
//                                // 字段长度
//                                'length' => 11,
//                                // 默认值
//                                'default' => '',
//                                // 非Null
//                                'not_null' => true,
//                                // 主键
//                                'main_key' => true,
//                                // 自增
//                                'incremental' => true,
//                                //也可以添加自定义列的值
//                                'query' => true,
//                            ],
//                            [
//                                // 字段名
//                                'field' => 'is_delete',
//                                // 字段注释
//                                'desc' => '是否删除1是0否',
//                                // 字段类型
//                                'type' => 'tinyint',
//                                // 字段长度
//                                'length' => 1,
//                                // 默认值
//                                'default' => 0,
//                                // 非Null
//                                'not_null' => false,
//                                // 主键
//                                'main_key' => false,
//                                // 自增
//                                'incremental' => false,
//                                //也可以添加自定义列的值
//                                'query' => false,
//                            ],
//                            [
//                                'field' => 'create_time',
//                                'desc' => '创建时间',
//                                'type' => 'datetime',
//                                'length' => null,
//                                'default' => '',
//                                'not_null' => false,
//                                'main_key' => false,
//                                'incremental' => false,
//                            ],
//                            [
//                                'field' => 'update_time',
//                                'desc' => '更新时间',
//                                'type' => 'datetime',
//                                'length' => null,
//                                'default' => '',
//                                'not_null' => false,
//                                'main_key' => false,
//                                'incremental' => false,
//                            ],
//                            [
//                                'field' => 'delete_time',
//                                'desc' => '删除时间',
//                                'type' => 'datetime',
//                                'length' => null,
//                                'default' => '',
//                                'not_null' => false,
//                                'main_key' => false,
//                                'incremental' => false,
//                            ]
//                        ],
//                        // 添加一行字段时，默认的值
//                        'default_values' => [
//                            //这里就是对应每列字段名=>值
//                            'type' => 'varchar',
//                            'length' => 255,
//                            //...
//                        ],
//                    ],
//                ]
//            ]
        ],
    ]
];
