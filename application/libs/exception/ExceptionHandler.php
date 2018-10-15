<?php
namespace app\libs\exception;

use Exception;
use think\exception\Handle;

/**
 * 自定义异常处理类
 */

class ExceptionHandler extends Handle
{
    protected $code;
    protected $msg;

    public function render(Exception $e)
    {
        if($e instanceof BaseException){
            // 自定义异常处理
            $this->code = $e->code;
            $this->msg = $e->msg;
        }else{
            // 系统异常处理
            if(config('app.app_debug')){
            // 调试模式，原样输出异常用以调试
               return parent::render($e); 
            }else{
                $this->code = 999;
                $this->msg = '系统内部错误';
                // 写入日志
            }
        }

        return json([
            'code' => $this->code,
            'msg' => $this->msg,
            'data' => [],
        ]);
    }
}