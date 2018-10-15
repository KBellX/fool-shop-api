<?php

namespace app\validate;

class Register extends BaseValidate
{
    protected $rule = [
        'username' => 'require|mobile',
        'password' => 'require|min:6',
    ];
}
