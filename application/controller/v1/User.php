<?php

namespace app\controller\v1;

use app\controller\BaseController;
use app\validate\Register as RegisterValidate;

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

        // 模型

        // 异常处理
    }
}
