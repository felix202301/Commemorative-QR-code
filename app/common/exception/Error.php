<?php


namespace app\common\exception;


use think\facade\Log;


class Error
{
    public function __construct($request, $e)
    {
        //可以不要了，已经修改直接写在app\common\exception\Http 方法 render里了
        $requestInfo = [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'host' => $request->host(),
            'uri' => $request->url(),
        ];
        $logInfo = [
            //请求路由
            "{$requestInfo['ip']} {$requestInfo['method']} {$requestInfo['host']}{$requestInfo['uri']}",
            //'[ ROUTE ] ' . var_export($this->getRouteInfo(), true),
            //'[ HEADER ] ' . var_export($request->header(), true),
            //请求参数
            '[ param ] ' . var_export($request->param(), true),
            //报错文件 行数
            '[ file ] ' . var_export($e->getFile() . ' line ' . $e->getLine(), true),
            //错误信息
            '[ error ] ' . var_export($e->getMessage(), true),
            '---------------------------------------------------------------',
        ];
        $logInfo = implode(PHP_EOL, $logInfo) . PHP_EOL;
        Log::record($logInfo, 'error');
    }


    /**
     * 获取路由信息
     * @param $request
     * @return array
     */
    protected function getRouteInfo($request): array
    {

        return [
            'rule' => $request->rule()->getRule(),
            'route' => $request->rule()->getRoute(),
            'option' => $request->rule()->getOption(),
            'var' => $request->rule()->getVars(),
        ];
    }
}
