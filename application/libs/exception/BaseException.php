<?php

namespace app\libs\exception;

use think\Exception;
/**
 * 自定义异常基类
 * 必须是php异常基类的子类，才能成为异常，拥有异常的属性
 * 这里继承tp5的异常基类，统一点
 */

class BaseException extends Exception
{
    public $code = 999;
    public $msg = '有异常..';

    public function __construct($code, $msg)
    {
        $this->code = $code;
        $this->msg = $msg;
    }
}