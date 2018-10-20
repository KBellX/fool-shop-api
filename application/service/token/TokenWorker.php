<?php
namespace app\service\token;

abstract class TokenWorker
{
    // 客户端类型
    protected $clientType;

    public function __construct($client_type)
    {
        // 抽象公共参数，如client_type
        $this->clientType = $client_type;
        // 三个主体方法，get, refresh, verify,都要判断 保存类型，重复了，应该写成子类了
        // 因此，父类应该是抽象类， 不能实例化， 所以要有创造者！
    }

    // 获取token
    abstract public function get($username, $password);

    // 刷新token
    abstract public function refresh($token, $refresh_token);

    // 验证token
    abstract public function verify($token);

    protected function generateToken()
    {
        $token = generate_token();
        $refresh_token = generate_token('refresh_token');

        return [
            'token' => $token,
            'refresh_token' => $refresh_token,
        ];
    }
}
