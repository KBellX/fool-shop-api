<?php

namespace app\http\middleware;

use app\libs\exception\TokenException;
use app\service\token\TokenFactory;

/**
 * 用户身份认证中间件
 */

class Auth
{
    public function handle($request, \Closure $next, $type)
    {
        $token = $request->header('token');
        $clientType = $request->clientType;

        if ($type === null) {
            // 默认类型
            if (!$token) {
                throw new TokenException(['code' => 12001, 'msg' => '令牌缺失']);
            }
            $request->user_id = (TokenFactory::instance($request->clientType))->verify($token);
        } else if ($type == 2) {
            // 类型2:传才验证
            if ($token) {
                $request->user_id = (TokenFactory::instance($request->clientType))->verify($token);
            }
        }

        return $next($request);
    }
}
