<?php

/**
 * Created by PhpStorm.
 * User: jamxio
 * Date: 2018/8/30
 * Time: 11:33
 */
//这个是搭在laravel框架下的部分代码
/**
 * hideMyInfo的时候，将user()的原始对象修改了
 * @see a::hideMyInfo()
 **/
/**
 * 数组却不会
 * @see changeArr()
 * */
class a
{
    /**
     * @return mixed
     */
    public function getSafeInfo()
    {
        return [$this->hideMyInfo(user()), user()];
    }

    /**
     * 返回隐藏的用户信息
     * @param $user
     * @return mixed
     */
    protected function hideMyInfo($user)
    {
        dump(user()->toArray());
        $user->email = $this->hideEmail($user->email);//隐藏用户邮箱部分
        $user->phone = $this->hideHalfOfPrefix($user->phone, '*', 10);

        dump(user()->toArray());
        return $user;
    }

    /**
     * 隐藏email
     * @param $email
     * @return string
     */
    protected function hideEmail($email)
    {
        if ($usernameLen = strpos($email, '@')) {
            $email = $this->hideHalfOfPrefix($email, '*', $usernameLen);
        } else {
            throw new \InvalidArgumentException('email格式不正确！');
        }
        return $email;
    }

    /**
     * 隐藏字符串str的前缀部分的中间部分
     * @param string $str 全串
     * @param string $char 替换的字符串
     * @param null $prefixLen 前缀长度
     * @return string
     */
    protected function hideHalfOfPrefix($str, $rep = '*', $prefixLen = null)
    {
        $prefixLen || $prefixLen = strlen($str);//没给前缀长度，则是隐藏全部字符串的中间部分
        $hideLen = ceil($prefixLen / 2);
        $restLen = $prefixLen - $hideLen;
        $frontLen = ceil($restLen / 2);

        return $str = substr_replace($str, str_repeat($rep, $hideLen), $frontLen, $hideLen);
    }
}

function changeArr($arr)
{
    $arr['target'] = 'modify';
    return $arr;
}
$test = ['target'=>'origin'];
print_r($test);
print_r(changeArr($test));
var_dump($test);
class b{
    public $var=0;
}
function changeObj($obj){
    $obj->var = 10;
    return $obj;
}
$objB = new b();
print_r($objB);
print_r(changeObj($objB));
var_dump($objB);//对象和资源类型占用内存大，所以传句柄引用？
/**
 * output
    Array
    (
    [target] => origin
    )
    Array
    (
    [target] => modify
    )
    Array
    (
    [target] => origin
    )
 **/