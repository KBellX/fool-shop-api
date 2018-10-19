<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 用户资源路由
Route::resource(':version/user', ':version.user');
// Route::resource(':version/user',':version.user')->only(['index']);
// 令牌额外路由
Route::group(':version/token', function () {
    Route::post('/user', ':version.token/getUserToken');
});
// 测试路由
Route::get(':version/address', ':version.address/test')->middleware('Auth');

return [

];
