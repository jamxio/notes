<?php
/**
 * Created by PhpStorm.
 * User: jamxio
 * Date: 2019/7/17
 * Time: 11:43
 */
//在AppServiceProvider.php里面加
\URL::forceRootUrl(request()->root().'/你的前缀');
\URL::forceScheme('https');