# receive-dump
--------------------------

nginx 配置 autoindex on;


# ISSUE
* #### DB 与 Eloquent 的连接对象不一致的问题，可能会造成事务不成功
* #### `php bin/hyperf.php start` 的情况，好像`composer test` 执行两次后，`$this->request`就变成了`null`
