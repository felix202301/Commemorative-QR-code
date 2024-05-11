<?php


namespace app\middleware;


use app\model\t_base\AdminLogModel;

class AdminLog
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);
        $ip = $request->ip();
        $ip = ip2long($ip);
        $param = $request->param();
        $responseData = $response->getData();
        $data = [
            'admin_id' => $request->adminId,
            'request_ip' => $ip,
            'request_path' => '/' . $request->pathinfo(),
            'request_method' => $request->method(),
            'request_param' => json_encode($param, 310),
            'response_code' => $responseData['code'],
            'response_msg' => $responseData['message'],
        ];
        AdminLogModel::create($data);
        return $response;
        //return $next($request);
    }

}
