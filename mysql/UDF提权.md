```mysql 

SHOW GLOBAL VARIABLES WHERE Variable_name="general_log_file";-- 日志文件存放位置
show variables like '%version_compile_os%'; -- 当前数据库操作系统
show variables like '%plugin%';-- 查看插件地址
-- CREATE | DROP ... IF EXISTS; 添加或替换功能或视图

use test;
drop function  if EXISTS foo_add;
create function foo_add(num1 DOUBLE,num2 DOUBLE)
	returns DOUBLE(10,3)
	return num1 + num2;
select test.foo_add(RAND(),6.345);


```
