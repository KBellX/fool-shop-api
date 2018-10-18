<?php
namespace app\validate;

use app\libs\exception\ParameterException;
use think\facade\Request;
use think\Validate;

class BaseValidate extends Validate
{
    // 公共 错误信息标题，子类不一致的自行覆盖
    protected $field = [
        'username' => '用户名',
        'password' => '密码',
    ];

    public function __construct(array $rules = [], array $message = [], array $field = [])
    {
        $this->setField();
        return parent::__construct();
    }

    // 设置错误信息标题，方便复用已设置的
    protected function setField()
    {
    }

    /**
     * 为什么叫goCheck，因为不是在执行真正的check，而是在check外包了一层，
     * 这种场景很常见，记一下命名习惯
     */
    public function goCheck()
    {
        // 目的是验证期望参数的非空和格式，不涉及数据库操作，不包括非期望参数的过滤
        $params = Request::param();
        if (!$this->check($params)) {
            // 不通过，直接抛异常
            throw new ParameterException(['msg' => $this->getError()]);
        }
    }
}
