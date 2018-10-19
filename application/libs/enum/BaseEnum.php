<?php

namespace app\libs\enum;

/**
 * getEnums是枚举类必须方法
 * $map, getOuts,toIn,toOut是当有外部名时才需要，即客户端传wap，而不是实际值1时，才需要这些转化方法
 */

class BaseEnum
{
    // 外部 => 内部 映射
    protected static $map = [];

    // 获取所有枚举变量
    public static function getEnums()
    {
        $reflect = new \ReflectionClass(get_called_class());
        return $reflect->getConstants();
    }

    // 获取所有外部名 
    public static function getOuts()
    {
        return array_keys(static::$map);
    }

    // 指定 外部 转化为 内部
    public static function toIn($key)
    {
        return static::$map[$key];
    }

    // 指定内部转化为外部
    public static function toOut($key)
    {
        $map = array_flip(static::$map);
        return $map[$key];
    }
}
