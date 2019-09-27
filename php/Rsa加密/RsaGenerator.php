#!/usr/bin/php
<?php
/**
 * Created by PhpStorm.
 * User: jamxio
 * Date: 2018/12/25
 * Time: 15:46
 */

$paramArr = getopt('', ['name::', 'empty:', 'no']);#需要传值
if (!$paramArr['name'] || !is_string($paramArr['name'])) {
    die('参数错误：请输入密钥对文件名。如：--name=我的密钥对' . PHP_EOL);
}
$keyFilePrefix = $paramArr['name'];

#开始生成密钥对
$privateName = $keyFilePrefix . '私';
$publicName  = $keyFilePrefix . '公';
#系统openssl程序生成私钥
if (($echoRes = system('openssl genrsa -out ' . $privateName . '.cs.pem 1024', $execRes)) !== false) {

    `openssl pkcs8 -topk8 -inform PEM -in $privateName.cs.pem -outform PEM -nocrypt -out $privateName.pem`;
    `openssl rsa -in {$privateName}.cs.pem -pubout -out {$publicName}.pem`;#系统openssl程序生成公钥
    file_put_contents($keyFilePrefix . '.php', '<?php
    return [
    \'public\'=>\'' . file_get_contents($publicName . '.pem') . '\',
    \'private\'=>\'' . file_get_contents($privateName . '.pem') . '\'
    ];');
} else {
    echo '执行错误：调用系统openssl函数生成私钥失败！';#注意，可以在wsl系统中执行这个php脚本
    exit();
}

echo '密钥对生成成功，现在开始进行测试验证' . PHP_EOL;
#载入密钥对配置文件验证密钥对的有效性
$config  = require $keyFilePrefix . '.php';
$randStr = function ($len) {
    $strs   = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
    $str    = '';
    $perLen = 10;
    for ($i = 0; $i < $len; $i += $perLen) {
        $perLen = min($len - $i, $perLen);
        $str    .= substr(str_shuffle($strs), mt_rand(0, strlen($strs) - $perLen - 1), $perLen);
    }
    return $str;
};
//1024/8 = 128。最长只能加密117，生成的都是128密文。
#要求用户
do {
    fwrite(STDOUT, '请输入您的测试字符串(quit退出)：');
    $m = fgets(STDIN);
    $m = trim($m) ?: $randStr(117);
    var_dump($m);
    $cPublic = openssl_public_encrypt($m, $c, $config['public']);

    $decryptRes = openssl_private_decrypt($c, $dPrivate, $config['private']);
    echo '数据加密还原：' . PHP_EOL . '密文：' . base64_decode($c) . PHP_EOL . '解密：' . $dPrivate . PHP_EOL;

    $cPrivate = openssl_private_encrypt($dPrivate, $s, $config['private']);

    $decryptRes = openssl_public_decrypt($s, $dPublic, $config['public']);
    echo '数据签名还原：' . PHP_EOL . '签名：' . base64_encode($s) . PHP_EOL . '原文：' . $dPublic . PHP_EOL;
} while ($m != 'quit');

