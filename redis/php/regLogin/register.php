<?php
header("Content-Type:text/html;charset=utf-8");

$tableEmailIdIndex = 'email.to.id';
$accessMethod      = $_SERVER['REQUEST_METHOD'];
if ($accessMethod == 'GET') {

    require 'registerForm.php';
    exit();
}

if (!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['nickname'])) {
    echo '请填写完整的信息';
    exit();
}
$email = $_POST['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '邮箱格式不正确，请重新检查';
    exit();
}
$rawPassword = $_POST['password'];
//验证密码是否安全
if (strlen($rawPassword) < 6) {
    echo '为了保证安全，密码成都至少为6。';
    exit;
}

$nickname = $_POST['nickname'];
require '../redisConnection.php';
$redis = new_connection();

/**
 * hexists 散列检查邮箱值的id是否存在
 */
if ($redis->hexists($tableEmailIdIndex, $email)) {
    echo '该邮箱已经被注册过了。';
    exit();
}

function bcryptHash($rawPassword, $round = 8)
{
    if ($round < 4 || $round > 31) $round = 8;
    $salt        = '$2a$' . str_pad($round, 2, '0', STR_PAD_LEFT) . '$';
    $randomValue = openssl_random_pseudo_bytes(16);
    $salt        .= substr(strtr(base64_encode($randomValue), '+', '.'), 0, 22);
    return crypt($rawPassword, $salt);
}

$hashedPassword = bcryptHash($rawPassword);

$userID = $redis->incr('users:count');
//存储用户信息
$redis->hmset("user:{$userID}", [
    'email' => $email,
    'password' => $hashedPassword,
    'nickname' => $nickname
]);
$redis->hset($tableEmailIdIndex, $email, $userID); //写邮箱到用户id的索引

echo '注册成功！';
