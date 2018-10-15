<?php

namespace app\controller\v1;

use app\controller\BaseController;
use app\libs\response\SuccessResponse;
use app\validate\Register as RegisterValidate;
use app\service\Register as RegisterService;

class User extends BaseController
{
    /**
     * ?
     * 注册
     */
    public function save()
    {
        // 验证器
        (new RegisterValidate())->goCheck();
        // 调用服务层模型
        $service = new RegisterService();
        $service->register($this->request->post());
        
        // 如果异常在这里抛，否则success返回
        // 所有异常都应该通过抛异常来输出，而不是单独赋值code，msg，因为那样不可控

        // 成功返回数据处理
        $data = ['a' => 'b'];
        return success($data, '注册成功');
    }
}
