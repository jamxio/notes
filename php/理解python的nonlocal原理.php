<?php
/**
 * Created by PhpStorm.
 * User: jamxio
 * Date: 2018/9/13
 * Time: 9:55
 */

function wai(){
    $h = 0;
    $a = function ()use(&$h){
        $h++;
        var_dump($h);
    };
    return $a;#返回了对象Closure
}
$b = wai();
$b();# $b没有被销毁，&$h 还有指向 refcount 不为零，故没销毁
$b();
$b();