<?php
namespace app\service\token;

use app\libs\enum\ClientTypeEnum;
use app\libs\exception\TokenException;
use app\libs\exception\UserException;
use app\model\UserAuth;
use think\Exception;
use think\facade\Cache;
use think\facade\Config;

class TokenCache extends TokenWorker
{
    public function get($username, $password)
    {
        $userAuth = UserAuth::getByUsername($username);
        if (!$userAuth || !validate_password($password, $userAuth->password)) {
            throw new UserException(['code' => 20002, 'msg' => '账号或密码不正确']);
        }
        $tokenData = $this->generateToken();
        $this->saveToCache($userAuth->user_id, $tokenData);

        $tokenData['client_type'] = ClientTypeEnum::toOut($this->clientType);
        return $tokenData;
    }

    public function refresh($token, $refresh_token)
    {
        $cacheKey = 'user@' . $this->clientType . '@' . $token;
        $userToken = Cache::pull($cacheKey);
        $userToken = json_decode($userToken, true);

        if (!$userToken || $userToken['refresh_token'] != $refresh_token) {
            throw new TokenException(['code' => 12004, 'msg' => '刷新token无效']);
        }

        $tokenData = $this->generateToken();

        $this->saveToCache($userToken['user_id'], $tokenData);

        $tokenData['client_type'] = ClientTypeEnum::toOut($this->clientType);
        return $tokenData;
    }

    public function verify($token)
    {
        $cacheKey = 'user@' . $this->clientType . '@' . $token;
        $userToken = Cache::get($cacheKey);

        $userToken = json_decode($userToken, true);

        if (!$userToken) {
            throw new TokenException(['code' => 12002, 'msg' => '令牌无效']);
        }

        $expire_in = Config::get('setting.token_expire_in');
        if ($userToken['update_time'] + $expire_in < time()) {
            throw new TokenException(['code' => 12003, 'msg' => '令牌过期失效']);
        }

        return $userToken['user_id'];
    }

    protected function saveToCache($user_id, $tokenData)
    {
        $cacheKey = 'user@' . $this->clientType . '@' . $tokenData['token'];
        $cacheValue = [
            'user_id' => $user_id,
            'refresh_token' => $tokenData['refresh_token'],
            'update_time' => time(),
        ];
        $cacheValue = json_encode($cacheValue);
        // 缓存有效期为刷新token有效期
        $expire_in = Config::get('setting.refresh_token_expire_in');
        $result = Cache::set($cacheKey, $cacheValue, $expire_in);
        if (!$result) {
            throw new Exception('写入缓存失败', 90001);
        }
    }
}
