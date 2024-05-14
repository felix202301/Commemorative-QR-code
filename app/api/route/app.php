<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::group(function () {
    Route::get('index/index', 'Index@index');
    Route::get('qr_code/getDetail', 'QrCode@getDetail');
    Route::get('login/getCode', 'Login@getCode');
    //需要登录token验证
    Route::group(function () {

    })->middleware(['apiAuthToken']);
})->prefix('app\api\controller\\');