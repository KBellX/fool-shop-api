<?php

namespace app\http\middleware;

use app\libs\exception\HeaderException;
use app\model\UserToken;
use think\facade\Config;

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
                throw new HeaderException(['code' => 11011, 'msg' => '令牌缺失']);
            }
            $request->user_id = $this->isTokenValid($token, $clientType);
        } else if ($type == 2) {
            // 类型2:传才验证
            if ($token) {
                $request->$user_id = $this->isTokenValid($token, $clientType);
            }
        }

        return $next($request);
    }

    protected function isTokenValid($token, $client_type)
    {
        $userToken = UserToken::getByToken($token, $client_type);
        if (!$userToken) {
            throw new HeaderException(['code' => 11012, 'msg' => '令牌无效']);
        }
        
        $expire_in = Config::get('setting.token_expire_in');
        if(strtotime($userToken->update_time) + $expire_in < time()){
            throw new HeaderException(['code' => 11013, 'msg' => '令牌过期失效']);
        }

        return $userToken->user_id;
    }
}
