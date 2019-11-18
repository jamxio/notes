<?php

class Factory
{
    static private $resolved = [];
    private static $route = [
        'a' => 'A@foo',
        'b' => 'A@foo1',
        'c' => 'A@foo2'
    ];

    public static function accessRoute($route)
    {
        $error   = function ($message) {
            throw new Exception("没办法," . $message, 1);
        };
        $closure = self::$route[$route] ?? $error('没路由！');
        list($class, $method) = explode('@', $closure);
        self::dispatch($class, $method);
    }

    protected static function dispatch($class, $method)
    {
        self::$resolved[$class] = $controller = self::$resolved[$class] ?? new $class();
        if (method_exists($controller, 'callAction'))
            return $controller->callAction($method);
        return $controller->{$method}();
    }
}

class T
{
    public function callAction($method, $params = [])
    {
        return call_user_func_array([$this, $method], $params);
    }

    public function __call($method, $params)
    {
        throw new Exception('没办法，方法找不到');
    }
}

class A extends T
{
    protected function foo($a = 'a', $d = 'd')
    {
        list($d, $a) = [$a, $d];#等同python 的 d,a = a,d
        [$a, $d] = [$d, $a];
        echo 'foo' . $d, $a . PHP_EOL;
    }

    public function foo2()
    {
        echo 'foo2';
    }

    private function foo1()
    {
        echo 'foo1';
    }
}

#(new A())->foo2();
#(new A())->foo(...['s','sd']/*等同于python 的` * generator` */);
#(new A())->foo1();
Factory::accessRoute('a');// fooda
Factory::accessRoute('c');// foo2
Factory::accessRoute('b');// 报错，因为方法私有
/**
 * 所以可见保护方法在laravel控制器里是不受保护作用的
 */
