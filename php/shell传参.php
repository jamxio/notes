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
/**
单独的字符（不接受值）e
后面跟随冒号的字符（此选项需要值）
后面跟随两个冒号的字符（此选项的值可选）c::
 */
$param_arr = getopt('a:b:w:ec::',['key:','value::']); # opt 即 options; 获取 a b 需commandLine 输入 -a[=| ]{valueA} -b[=| ]{valueB}
var_dump($param_arr);//如果命令行没有对应的ab的值，则数组为空，如果多次写有-(.*)a[=| ](.*)则，所有值读成数组

#·使用stdout与stdin输入输出流进行用户交互
// todo windows下读入中文无法正确获取命令行的内容
fwrite(STDOUT,'请输入您的参数a值：');# STDOUT 即 fopen('php://stdout','w');写模式php交互协议输出句柄
$a = fgets(STDIN);# STDIN 即 fopen('php://stdin','r');读模式php交互协议输入句柄
echo '您输入的$a是：'.$a;
file_put_contents('php://stdout','how are you,my friend?'.PHP_EOL);
$incontent = fgets(fopen('php://stdin','r'));# fgets 从句柄读一行内容
echo '您输入的内容是'.$incontent;

