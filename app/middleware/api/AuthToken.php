<?php

namespace app\middleware\api;

use common\Token;
use think\response\Json;

class AuthToken
{
    /**
     * 权限验证
     * @param $request
     * @param \Closure $next
     * @return mixed|Json
     */
    public function handle($request, \Closure $next)
    {
        //token验证
        $token = $request->header('X-Token', '');
        $data = Token::verify($token);
        if ($data === false) return error_encrypt(3002);
        //设置登录用户信息
        $request->userId = $data['id'];
        return $next($request);
    }
}
