<?php
namespace app\libs\exception;

/**
 * 用户相关异常
 */

class UserException extends BaseException
{
    public $code = 20000;

    public $msg = '用户异常';
}