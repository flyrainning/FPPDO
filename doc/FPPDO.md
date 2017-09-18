# FPPDO




## 创建连接


## 可用对象

## 方法

### debug

是否输出调试信息

`debug($dbg=true)`

若`$dbg=true`，则直接输出正在执行的sql语句到浏览器

```
$db->debug();//开启调试信息输出
```


### v

格式化变量为可直接插入sql语句中的字符串，防止sql注入，在自行拼接sql查询字符串的时候很有用

```
$value="some str '!@#$";
$value_quote=$db->v($value);
$sqls="select * from `table` where `remark` like '%$value_quote%';";
$db->q($sqls);

```
### v_arr

作用同v(),只不过v_arr处理的不是单一变量，而是一个数组，可处理数组中的每个元素

```
$value=array(
  'a'=>'value aa',
  'b'=>'value bb'
  );
$value_quote_arr=$db->v_arr($value);
foreach($value_quote_arr as $value_quote){
  $sqls="select * from `table` where `remark` like '%$value_quote%';";
  $db->q($sqls);
}


```

### 
