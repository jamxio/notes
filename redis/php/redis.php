<?php
require './predis/autoload.php';


function getRedisConnection(array $config)
{
    return $redis = new Predis\Client($config);
}

$redis = getRedisConnection([
    'scheme' => 'tcp',
    'host' => '127.0.0.1',
    'port' => '6379',
    'password' => 'b840fc02d524045429941cc15f59e41cb7be6c52',
]);
//列表
$redis->lpush('foo', [3, 3, 54]);
try {
    //字符串
    echo $redis->get('foo');
} catch (Throwable $t) {
    echo $t->getMessage();
}

//字符串多键操作
$userName = [
    'user:1:name' => 'Tom',
    'user:2:name' => 'Jack',
];
$redis->mset($userName);//多键写入
$users = array_keys($userName);
print_r(array_combine($users, $redis->mget($users)));//多键读取
//散列
$user1 = [
    'name' => 'Tom',
    'age' => '32'
];
$redis->hset('user:1', 'sex', 'boy');//单一哈希赋值
$redis->hmset('user:1', $user1);//批量哈希赋值
echo $redis->hget('user:1', 'name');
$user = $redis->hgetall('user:1');//获取哈希所有值
print_r($user);
//列表
$items = ['a', 'b'];
$redis->lpush('list', $items);//批量入队列，$items是可变个数参数 $_
//集合
$redis->sadd('set', $items);//和列表的同理
//有序集
$itemScore = [
    'Tom' => '100',
    'Jack' => 89
];
//相当于zadd('zset','100','Tom','89','Jackf');
$redis->zadd('zset', $itemScore);//同样predis包已经支持批量的有序集元素加入
$redis->zadd('zset', '100', 'Jamxio', '32', 'Ll');
echo($redis->zcard("zset"));//基数

//排序
$redis->sort('mylist', [
    'by' => 'weight_*',
    'limit' => [0, 10],
    'get' => ['value_*', '#'],
    'sort' => 'asc',
    'alpha' => true,
    'store' => 'result',
]);