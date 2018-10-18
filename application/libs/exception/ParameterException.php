<?php

namespace app\libs\exception;

/**
 * 参数错误异常
 */

class ParameterException extends BaseException
{
    public $code = 10000;
    public $msg = '参数错误';
}