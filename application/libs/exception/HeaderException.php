<?php

namespace app\libs\exception;

/**
 * Header参数错误异常
 */

class HeaderException extends BaseException
{
    public $code = 11000;
    public $msg = 'Header参数错误';
}