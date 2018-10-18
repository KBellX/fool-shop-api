<?php

namespace app\model;

use think\Model;

class BaseModel extends Model
{
    // 新增时自动赋值
    protected $insert = [
        'data_state' => 1,
    ];
}
