<?php
namespace app\validate;

class Token extends BaseValidate
{
    // 登陆时无需验证格式
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
    ];
}
