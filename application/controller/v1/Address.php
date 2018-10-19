<?php

namespace app\controller\v1;

use app\controller\BaseController;

class Address extends BaseController
{
    // 一个需要授权访问的接口
    public function test()
    {
        $data = [
            'user_id' => $this->request->user_id,
        ];
        return success($data, '需授权访问的接口访问成功');
    }
}
