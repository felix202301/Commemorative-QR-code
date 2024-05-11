<?php

namespace app\common\exception;

use think\exception\Handle;
use think\exception\HttpException;
use think\exception\ValidateException;
use think\facade\Log;
use think\Response;
use Throwable;

class Http extends Handle
{
    public function render($request, Throwable $e): Response
    {
        //在debug关闭的情况下，记录错误信息
        if (app()->isDebug() === false) {
            //不需要记录信息（日志）的异常类列表
            $ignore = false;
            foreach ($this->ignoreReport as $class) {
                if ($e instanceof $class) {
                    $ignore = true;
                }
            }
            if ($ignore === false) {
                //记录错误信息位置
                $this->getError($request, $e);
                //记录错误信息位置
                //new Error($request, $e);
            }
        }

        // 参数验证错误
        if ($e instanceof ValidateException) {
            return error($e->getError(), 4022);
        }

        // 请求异常
        if ($e instanceof HttpException && $request->isAjax()) {
            return response($e->getMessage(), $e->getStatusCode());
        }

        // 其他错误交给系统处理(可以日志记录)
        return parent::render($request, $e);
    }

    /**
     * 获取错误信息，并写入日志
     * @param $request
     * @param $e
     */
    public function getError($request, $e){
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
            '[ error ] ' . var_export($this->getMessage($e), true),
            '---------------------------------------------------------------',
        ];
        $logInfo = implode(PHP_EOL, $logInfo) . PHP_EOL;
        Log::record($logInfo, 'error');
    }

}
