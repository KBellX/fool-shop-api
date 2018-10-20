<?php
namespace app\controller\v1;

use app\controller\BaseController;
use app\service\token\TokenFactory;
use app\validate\RefreshToken;
use app\validate\Token as TokenValidate;
use think\facade\Request;

/**
 * 管理token资源
 */

class Token extends BaseController
{
    /**
     * 获取用户token
     */
    public function getUserToken()
    {
        (new TokenValidate())->goCheck();
        $data = $this->request->only(['username', 'password']);
        $service = TokenFactory::instance($this->request->clientType);
        $tokenData = $service->get($data['username'], $data['password']);

        return success($tokenData);
    }
    /**
     * 刷新用户token
     */
    public function refreshUserToken()
    {
        (new RefreshToken())->goCheck();
        $data = $this->request->only(['token', 'refresh_token']);
        $service = TokenFactory::instance($this->request->clientType);
        $tokenData = $service->refresh($data['token'], $data['refresh_token']);

        return success($tokenData);
    }

    /**
     * 验证token
     */

    // 管理其它token
}
