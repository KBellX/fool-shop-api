<?php
namespace app\model;

class UserAuth extends BaseModel
{
    public static function getByUsername($username)
    {
        return static::where(['username' => $username])->find();
    }
}
