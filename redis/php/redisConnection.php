<?php
require __DIR__ . '/predis/autoload.php';
$redisConfig = [
    'scheme' => 'tcp',//场景tcp模式
    'host' => '127.0.0.1',
    'port' => '6379',
    'password' => 'b840fc02d524045429941cc15f59e41cb7be6c52'
];
/**
 * 获取redis连接
 * @reviser jamxio
 * @lastModify 2020/2/26 17:06
 * @return \Predis\Client
 */
function new_connection()
{
    return new Predis\Client();
}

