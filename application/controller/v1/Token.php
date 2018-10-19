<?php
namespace app\controller\v1;

use app\controller\BaseController;
use app\service\Token as TokenService;
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
        $data['client_type'] = $this->request->clientType;
        $service = new TokenService();
        $tokenData = $service->get($data);

        return success($tokenData);
    }
    /**
     * 刷新用户token
     */
    public function refreshUserToken()
    {
        (new RefreshToken())->goCheck();
        $data = $this->request->only(['token', 'refresh_token']);
        $data['client_type'] = $this->request->clientType;
        $service = new TokenService();
        $tokenData = $service->refresh($data);

        return success($tokenData);
    }

    /**
     * 验证token
     */

    // 管理其它token
}
