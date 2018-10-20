<?php
namespace app\service\token;

use app\libs\enum\ClientTypeEnum;
use app\libs\exception\TokenException;
use app\libs\exception\UserException;
use app\model\UserAuth;
use app\model\UserToken;
use think\facade\Config;

class TokenDb extends TokenWorker
{
    public function get($username, $password)
    {
        $userAuth = UserAuth::getByUsername($username);
        if (!$userAuth || !validate_password($password, $userAuth->password)) {
            throw new UserException(['code' => 20002, 'msg' => '账号或密码不正确']);
        }
        $tokenData = $this->generateToken();

        $userToken = UserToken::where([
            'user_id' => $userAuth->user_id,
            'client_type' => $this->clientType,
        ])->find();

        if (!$userToken) {
            UserToken::create([
                'user_id' => $userAuth->user_id,
                'client_type' => $this->clientType,
                'token' => $tokenData['token'],
                'refresh_token' => $tokenData['refresh_token'],
            ]);
        } else {
            // 已存在token则更新之, 让旧的失效。 缓存方式没想到办法实现..
            $userToken['token'] = $tokenData['token'];
            $userToken['refresh_token'] = $tokenData['refresh_token'];
            $userToken->save();
        }

        $tokenData['client_type'] = ClientTypeEnum::toOut($this->clientType);
        return $tokenData;
    }

    public function refresh($token, $refresh_token)
    {
        $expire_in = Config::get('setting.refresh_token_expire_in');

        $userToken = UserToken::where([
            'token' => $token,
            'refresh_token' => $refresh_token,
            'client_type' => $this->clientType,
        ])->where('update_time', '>=', time() - $expire_in)->find();

        if (!$userToken) {
            throw new TokenException(['code' => 12004, 'msg' => '刷新token无效']);
        }

        $tokenData = $this->generateToken();

        $userToken->token = $tokenData['token'];
        $userToken->refresh_token = $tokenData['refresh_token'];
        $userToken->save();

        $tokenData['client_type'] = ClientTypeEnum::toOut($this->clientType);
        return $tokenData;
    }

    public function verify($token)
    {
        $userToken = UserToken::getByToken($token, $this->clientType);
        if (!$userToken) {
            throw new TokenException(['code' => 12002, 'msg' => '令牌无效']);
        }

        $expire_in = Config::get('setting.token_expire_in');
        if (strtotime($userToken->update_time) + $expire_in < time()) {
            throw new TokenException(['code' => 12003, 'msg' => '令牌过期失效']);
        }

        return $userToken->user_id;
    }
}
