<?php

namespace app\http\middleware;

use app\libs\enum\ClientTypeEnum;
use app\libs\exception\HeaderException;

class CheckHeader
{
    protected $enableClientType = [
        'wap', 'mini_program', 'test',
    ];

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
        if (!in_array($clientType, $this->enableClientType)) {
            throw new HeaderException(['code' => 11002, 'msg' => '客户端类型不存在']);
        }

        $request->clientType = $this->setClientType($clientType);

        return $request;
    }

    // 客户端类型 外部->内部 映射
    protected function setClientType($key)
    {
        $map = [
            'wap' => ClientTypeEnum::WAP,
            'mini_program' => ClientTypeEnum::MINI_PROGRAM,
        ];

        return $map[$key];
    }
}
