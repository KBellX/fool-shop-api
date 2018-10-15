<?php
namespace app\validate;

use think\Validate;
use think\facade\Request;

class BaseValidate extends Validate
{
    // 公共 错误信息标题，子类不一致的自行覆盖
    protected $field = [
        'username' => '用户名',
        'password' => '密码',
    ];

    /**
     * 为什么叫goCheck，因为不是在执行真正的check，而是在check外包了一层，
     * 这种场景很常见，记一下命名习惯
     */
    public function goCheck()
    {
        // 目的是验证期望参数的非空和格式，不涉及数据库操作，不包括非期望参数的过滤
        $params = Request::param();
        if(!$this->check($params)){
            // 不通过，直接抛异常
            echo $this->getError();
        }
    }
}