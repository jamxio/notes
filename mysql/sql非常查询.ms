`where ID = '1,3,4' 等同于 where ID =3;`  
`where ID not in (null,1,3,4)` 不会有任何数据
```mysql 
-- 以相同结构创建表/临时表
CREATE TEMPORARY TABLE test.a like test.admin_users;

```
