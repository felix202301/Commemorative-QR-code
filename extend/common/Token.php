<?php


namespace common;


use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;

class Token
{
    /**
     * 创建token
     * @param $admin
     * @param array $jwtConfig
     * @return string
     */
    public static function create($admin, $jwtConfig = [])
    {
        if (empty($jwtConfig)) $jwtConfig = config('other.jwt_config');
        $key = $jwtConfig['key'];
        $time = time();
        $payload = array(
            "iss" => $jwtConfig['iss'],//签发者
            "aud" => $jwtConfig['aud'],//jwt所面向的用户
            "iat" => $time, //签发时间
            "nbf" => $time,//在什么时间之后该jwt才可用
            "exp" => $time + $jwtConfig['exp'],//过期时间
            'adminInfo' => $admin,
        );
        return JWT::encode($payload, $key, $jwtConfig['alg']);
    }

    /**
     * 验证token
     * @param $token
     * @param array $jwtConfig
     * @return array|bool
     */
    public static function verify($token, $jwtConfig = [])
    {
        try {
            //jwt 检测
            if (empty($jwtConfig)) $jwtConfig = config('other.jwt_config');
            $key = $jwtConfig['key'];
            $alg = $jwtConfig['alg'];
            //验证token
            $decoded = JWT::decode($token, new Key($key, $alg));
            //转为数组
            $decoded_array = (array)$decoded;
        } catch (SignatureInvalidException $e) {   // 签名不正确
            return false;
        } catch (BeforeValidException $e) {        // 当前签名还不能使用，和签发时生效时间对应
            return false;
        } catch (ExpiredException $e) {            // 签名已过期
            return false;
        } catch (\Exception $e) {
            return false;
        }
        return (array)$decoded_array['adminInfo'];
    }
}
