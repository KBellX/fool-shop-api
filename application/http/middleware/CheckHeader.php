<?php

namespace app\http\middleware;

use app\libs\enum\ClientTypeEnum;
use app\libs\exception\HeaderException;

class CheckHeader
{
    public function handle($request, \Closure $next)
    {
        $this->checkClientType($request);

        return $next($request);
    }

    // 验证并记录客户端类型
    protected function checkClientType($request)
    {
        $clientType = $request->header('Client-Type');
        if (!$clientType) {
            throw new HeaderException(['code' => 11001, 'msg' => '客户端类型缺失']);
        }
        if (!in_array($clientType, ClientTypeEnum::getOuts())) {
            throw new HeaderException(['code' => 11002, 'msg' => '客户端类型不存在']);
        }

        $request->clientType = ClientTypeEnum::toIn($clientType);

        return $request;
    }

}
