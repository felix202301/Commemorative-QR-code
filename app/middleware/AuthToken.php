<?php

namespace app\middleware;

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
        $admin = Token::verify($token);
        if ($admin === false) return error('token失效', 5001);
        //设置登录用户信息
        $request->adminId = $admin['id'];
        $request->isSuper = $admin['is_super'];
        //查询权限角色权限
        if ($admin['is_super'] !== 1) {
            $routingList = get_routing($admin['id'], $admin['is_super'], 1);
            $requestPath = get_request_path();
            $requestPath = preg_replace('/[0-9]+/', '{id}', $requestPath);
            if (!in_array($requestPath, $routingList)) return error('您没有权限');
        }
        return $next($request);
    }
}
