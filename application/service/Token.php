<?php
namespace app\service;

use app\libs\enum\ClientTypeEnum;
use app\libs\exception\UserException;
use app\model\UserAuth;
use app\model\UserToken;

class Token
{
    public function get($data)
    {
        $userAuth = UserAuth::getByUsername($data['username']);
        if (!$userAuth || !validate_password($data['password'], $userAuth->password)) {
            throw new UserException(['code' => 20002, 'msg' => '账号或密码不正确']);
        }

        $tokenData = $this->generateToken();

        $userToken = UserToken::where([
            'user_id' => $userAuth['user_id'],
            'client_type' => $data['client_type'],
        ])->find();

        if (!$userToken) {
            UserToken::create([
                'user_id' => $userAuth->user_id,
                'client_type' => $data['client_type'],
                'token' => $tokenData['token'],
                'refresh_token' => $tokenData['refresh_token'],
            ]);
        } else {
            // 已存在token则更新之
            $userToken['token'] = $tokenData['token'];
            $userToken['refresh_token'] = $tokenData['refresh_token'];
            $userToken->save();
        }

        $tokenData['client_type'] = ClientTypeEnum::toOut($data['client_type']);
        return $tokenData;
    }

    protected function generateToken()
    {
        $token = generate_token();
        $refresh_token = generate_token('refresh_token');

        return [
            'token' => $token,
            'refresh_token' => $refresh_token,
        ];
    }
}
