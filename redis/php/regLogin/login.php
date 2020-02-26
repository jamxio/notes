<?php
header("Content-Type:text/html;charset=utf-8;");
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    echo '请填写完整的信息';
    exit();
}
$email       = $_POST['email'];
$rawPassword = $_POST['password'];
require '../redisConnection.php';
$redis  = new Predis\Client();
$userID = $redis->hget('email.to.id', $email);

if (!$userID) {
    echo '用户名或密码错误';
    exit();
}

$hashPassword = $redis->hget("user:{$userID}", 'password');
function bcryptVerify($rawPassword, $storedHash)
{
    //加密后的盐值可以直接在密文里面找
    return crypt($rawPassword, $storedHash) == $storedHash;
}

if (!bcryptVerify($rawPassword, $hashPassword)) {
    echo '用户名或密码错误';
    exit;
}
echo '登录成功';

