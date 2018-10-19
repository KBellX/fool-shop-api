<?php
namespace app\libs\enum;

class ClientTypeEnum extends BaseEnum
{
    const WAP = 1;

    const MINI_PROGRAM = 2;

    protected static $map = [
        'wap' => self::WAP,
        'mini_program' => self::MINI_PROGRAM,
    ];
}
