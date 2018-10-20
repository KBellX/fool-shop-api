<?php

namespace app\service\token;

use think\Exception;
use think\facade\Config;

/**
 * token工厂类
 */

class TokenFactory
{
    public static function instance($client_type)
    {
        $keepType = Config::get('setting.token_keep_type');
        switch ($keepType) {
            case 'cache':
                return new TokenCache($client_type);
                break;
            case 'db':
                return new TokenDb($client_type);
                break;
            default:
                throw new Exception($keepType . '的token保存方式不存在', 90002);
        }
    }
}
