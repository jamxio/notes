<?php
/**
 * Created by PhpStorm.
 * User: jamxio
 * Date: 2018/11/12
 * Time: 11:31
 */

#·使用 $argc 、 $argv 获取
echo $argc,'个参数';#参数个数，以空格区分参数，脚本名也算在内
print_r($argv);#argv 是参数值数组，键名索引为数值

//-------------------------
#·使用 getopt()
$param_arr = getopt('a:b:'); # opt 即 options; 获取 a b 需commandLine 输入 -a[=| ]{valueA} -b[=| ]{valueB}
print_r($param_arr);//如果命令行没有对应的ab的值，则数组为空

#·使用stdout与stdin输入输出流进行用户交互

fwrite(STDOUT,'请输入您的参数a值：');# STDOUT 即 fopen('php://stdout','w');写模式php交互协议输出句柄
$a = fgets(STDIN);# STDIN 即 fopen('php://stdin','r');读模式php交互协议输入句柄
echo '您输入的$a是：'.$a;
file_put_contents('php://stdout','how are you,my friend?'.PHP_EOL);
$incontent = fgets(fopen('php://stdin','r'));# fgets 从句柄读一行内容
echo '您输入的内容是'.$incontent;

