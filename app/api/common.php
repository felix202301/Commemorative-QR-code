<?php
// 这是系统自动生成的公共文件

if (!function_exists('success_encrypt')) {
    /**
     * 请求成功返回
     * @param array $data
     * @param int $code
     * @return \think\Response
     */
    function success_encrypt($data = [], $code = 200)
    {
        $language = \think\facade\Request::param('language/d', 0);
        $result['code'] = $code;  // 状态码
        $result['message'] = (new \common\MessageLang())->load(config('lang.messages_list'), $language)->getMessage($code);
        $result['data'] = $data;  // 请求返回数据
        return \think\Response::create($result, '\common\Encrypt');
    }
}

if (!function_exists('error_encrypt')) {
    /**
     * 请求失败返回
     * @param int $code
     * @param string $message
     * @return \think\Response
     */
    function error_encrypt($code = 400, $message = '')
    {
        $language = \think\facade\Request::param('language/d', 0);
        $result['code'] = $code;
        if ($message) {
            $result['message'] = $message;
        } else {
            $result['message'] = (new \common\MessageLang())->load(config('lang.messages_list'), $language)->getMessage($code);
        }
        return \think\Response::create($result, '\common\Encrypt');
    }
}

