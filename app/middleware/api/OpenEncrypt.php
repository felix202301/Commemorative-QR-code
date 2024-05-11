<?php


namespace app\middleware\api;


use think\facade\Config;
use think\facade\Log;

class OpenEncrypt
{
    /**
     * 权限验证
     * @param $request
     * @param \Closure $next
     * @return mixed|Json
     */
    public function handle($request, \Closure $next)
    {
        $apiDebug = $request->param('api_test', '');

        if (empty($apiDebug)) {
            //获取分组名称
            $groupName = $request->param('group_name');
            $config = config("encrypt.{$groupName}");
            //设置加密秘钥
            $signKey = '';
            if ($config) {
                Config::set($config, 'sign_key');
                $signKey = $config['sign_key'] ?? '';
            } else {
                Log::error('加密秘钥配置为空,请设置');
            }
            //验证时间
            $timestamp = $request->param('timestamp/d', 0);
            $time = time();
            if ($time - 300 > $timestamp || $timestamp > $time + 300) {
                return error_encrypt(402);
            }
            if (!$this->verify($request->param(), $signKey)) {
                return error_encrypt(402);
            }
        }

        return $next($request);
    }

    //验证签名
    public function verify($param, $signKey)
    {
        $params = [];
        foreach ($param as $k => $v) {
            if ($v === '' || in_array($k, ['sign', 'group_name'])) continue;
            $params[$k] = $v;
        }
        ksort($params);//按照键名进行升序排序
        $params2 = [];
        foreach ($params as $key => $val) {
            $params2[] = "{$key}={$val}";
        }
        $params2 = implode('&', $params2);
        if (isset($param['sign']) && md5($params2 . $signKey) === $param['sign']) {
            return true;
        }
        return false;
    }
}
