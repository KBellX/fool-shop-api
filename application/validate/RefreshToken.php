<?php
namespace app\validate;

class RefreshToken extends BaseValidate
{
    protected $rule = [
        'token' => 'require',
        'refresh_token' => 'require',
    ];
}
