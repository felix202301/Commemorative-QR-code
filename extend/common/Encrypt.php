<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace common;

use encrypt\XDes\Des;
use encrypt\XRsa\XRsa;
use think\Cookie;
use think\Response;
use think\facade\Config;

/**
 * Json Response
 */
class Encrypt extends Response
{
    // 输出参数
    protected $options = [
        'json_encode_param' => JSON_UNESCAPED_UNICODE,
    ];

    protected $contentType = 'application/json';

    public function __construct(Cookie $cookie, $data = '', int $code = 200)
    {
        $this->init($data, $code);
        $this->cookie = $cookie;
    }

    /**
     * 处理数据
     * @param mixed $data
     * @return false|mixed|string|string[]
     */
    protected function output($data)
    {
        $return_rsa = Config::get("sign_key.return_rsa");
        $return_des = Config::get("sign_key.return_des");
        // 返回JSON数据格式到客户端 包含状态信息
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        /**************自定义判断进行rsa非对称加密**************/
        if ($return_rsa) {
            $publicKey = file_get_contents(EXTEND_PATH . 'encrypt/XRsa/pub.pem');
            $privateKey = file_get_contents(EXTEND_PATH . 'encrypt/XRsa/pri.pem');
            $rsa = new XRsa($publicKey, $privateKey);
            $data = $rsa->privateEncrypt($data);
        }
        /**************自定义判断进行des对称加密**************/
        if ($return_des) {
            $des_key = Config::get("sign_key.des_key");
            $des_iv = Config::get("sign_key.des_iv");
            $des_cipher = Config::get("sign_key.des_cipher");
            $des = new Des($des_key, $des_iv);
            $data = $des->encrypt($data);
        }
        /**************自定义判断进行json加密结束**************/
        if (false === $data) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }
        return $data;

    }

}
