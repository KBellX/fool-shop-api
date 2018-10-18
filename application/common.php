<?php

use app\libs\response\SuccessResponse;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 
 * 成功返回json数据
 * @param mixed      $data   输出数据
 * @param string     $msg    提示信息
 * @param int|string $code   状态码
 * @param array      $header 头信息
 * @return Response
 */
function success($data = [], $msg = '', $code = 200, $header = [])
{
    // 为了不破坏框架的response类，又给控制器返回信息提供方便，这样做..
    SuccessResponse::$msg = $msg;
    // 传success是为了 避开内置的response类型，创建静态调用者successResponse实例
    return SuccessResponse::create($data, 'success', $code, $header);
}

/**
 * 密码hash
 */
function generate_password_hash($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * 验证密码
 */
function validate_password($password, $hash)
{
    return password_verify($password, $hash);
}
