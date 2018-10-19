<?php
namespace app\model;

class UserToken extends BaseModel
{
    public static function getByToken($token, $client_type)
    {
        return static::where(['token' => $token, 'client_type' => $client_type])->find();
    }
}
