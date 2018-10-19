<?php
namespace app\libs\exception;

/**
 * Token异常
 */

class TokenException extends BaseException
{
    public $code = 12000;
    public $msg = 'Token错误';
}
