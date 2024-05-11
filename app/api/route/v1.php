<?php

use think\facade\Route;

Route::group('v1', function () {
    //不加密
    Route::post('index/no_encryption', 'Index@noEncryption');
    //需要开启加密
    Route::group(function () {
        //要加密
        Route::post('index/to_encrypt', 'Index@toEncrypt');
        Route::post('index/login', 'Index@Login');
        //需要登录token验证
        Route::group(function () {
            //要登录
            Route::post('index/to_login', 'Index@toLogin');
        })->middleware(['apiAuthToken']);
    })->middleware(['apiOpenEncrypt']);
})->prefix('app\api\controller\v1\\')->append(['group_name' => 'v1']);
