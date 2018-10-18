<?php

namespace app\service;

use app\model\User;
use app\model\UserAuth;
use think\Db;
use app\libs\exception\UserException;

/**
 * 注册 服务层模型
 * 内容包括：普通注册，微信登陆后注册，代码多的话分成两个子类
 */

class Register
{
    public function register($data)
    {
        $user = UserAuth::where(['username' => $data['username']])->find();
        if ($user) {
            throw new UserException(20001, '账号已被注册');
        }

        // 至此所有自定义验证已通过，如果仍插入不成功，返回系统异常

        try {
            Db::startTrans();
            $this->save($data);
            Db::commit();
        } catch (Exceptiion $e) {
            // TODO::留个疑问：日常写try，catch时捕捉的异常应该是php根异常还是tp根异常?
            Db::rollback();
            throw $e;
        }

        // 若需要返回用户数据，在这里获取
    }

    // 插入数据库
    protected function save($data)
    {
        // 插入用户表
        $user = User::create([
            'mobile' => $data['username'],
        ]);

        // 插入用户认证表
        $data['user_id'] = $user->id;
        $data['password'] = generate_password_hash($data['password']);
        $userAuth = UserAuth::create($data);

        // 扩展：插入其它表
    }
}
