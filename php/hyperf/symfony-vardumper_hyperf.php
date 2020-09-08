<?php

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');

error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));
! defined('SWOOLE_HOOK_FLAGS') && define('SWOOLE_HOOK_FLAGS', SWOOLE_HOOK_ALL | SWOOLE_HOOK_CURL);

require BASE_PATH . '/vendor/autoload.php';

// Self-called anonymous function that creates its own scope and keep the global namespace clean.
(function () {
    Hyperf\Di\ClassLoader::init();

    /** @var \Psr\Container\ContainerInterface $container */
    $container = require BASE_PATH . '/config/container.php';

    //重写dump
    if (extension_loaded('swoole') && PHP_SAPI == 'cli') {
        $cloner = new Symfony\Component\VarDumper\Cloner\VarCloner();
        $dumper = new class extends Symfony\Component\VarDumper\Dumper\HtmlDumper {
            protected function echoLine($line, $depth, $indentPad)
            {
                if (-1 !== $depth) {
                    echo str_repeat($indentPad, $depth) . $line . "\n";
                }
            }
        };
        Symfony\Component\VarDumper\VarDumper::setHandler(function ($var) use ($dumper, $cloner) {
            ob_start();
            $dumperClone = clone $dumper;
            $dumperClone->dump($cloner->cloneVar($var));
            $content = ob_get_clean();
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => 'http://192.168.1.61:97/receive.php?name=a',
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => $content,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            ]);
            curl_exec($ch);
            if(curl_errno($ch) !== 0){
                curl_close($ch);
                throw new \Exception('dump curl error');
            }
            curl_close($ch);
        });
    }

    $application = $container->get(\Hyperf\Contract\ApplicationInterface::class);
    $application->run();
})();
