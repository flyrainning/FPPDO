# FPPDO




## 创建连接

FPPDO继承自PHP的PDO对象，采用相同的构造方式

```
$db=new FPPDO($dsn, $user, $passwd,$options);
```

|   参数   |               说明                |
| -------- | --------------------------------- |
| $dsn     | 连接字符串，附加选项，参考PDO设置 |
| $user    | 用户名                            |
| $passwd  | 密码                              |
| $options | 附加选项，参考PDO设置             |


> PDO参考资料 [PDO](http://php.net/manual/en/book.pdo.php)


## 可用对象

`result` 查询结果集

```
$db->q("show databases");
print_r($db->result);
```

## 变量绑定

在编写查询时，推荐使用变量绑定写法代替直接拼接字符串的形式。

q()、select()、delete()、has()都支持变量绑定

### 使用数字索引绑定

在sql语句中使用`?`占位符，传入的变量可以是变量列表，也可以是数组

```
$calories = 150;
$colour = 'red';
$db->q('SELECT name, colour, calories
    FROM fruit
    WHERE calories < ? AND colour = ?' , $calories , $colour );

//等同于
$db->q('SELECT name, colour, calories
    FROM fruit
    WHERE calories < ? AND colour = ?' , array($calories , $colour) );

```

### 使用字符串索引绑定

在sql语句中使用`:+name`占位符，传入的变量为字符串索引的数组

```
$calories = 150;
$colour = 'red';
$db->q('SELECT name, colour, calories
    FROM fruit
    WHERE calories < :calories AND colour = :colour' ,
    array(
      'calories'=>$calories,
      'colour'=>$colour,
      )
    );

```

## 方法

### debug

是否输出调试信息

`debug($dbg=true)`

若`$dbg=true`，则直接输出正在执行的sql语句到浏览器

```
$db->debug();//开启调试信息输出
```


### v

`v($string)`

格式化变量为可直接插入sql语句中的字符串，防止sql注入，在自行拼接sql查询字符串的时候很有用

```
$value="some str '!@#$";
$value_quote=$db->v($value);
$sqls="select * from `table` where `remark` like '%$value_quote%';";
$db->q($sqls);

```
### v_arr

`v_arr($arr)`

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

### prefix

`prefix($prefix='')`

设置表前缀，自动以`$prefix.$table`的形式形成表名

### table

`table($table,$change_table=true)`

指定要使用的表，在insert()，select()等功能中默认使用此表，同时，在q()中的sql语句中，可以使用`{table}`引用当前表

函数返回表名（包含前缀），若$change_table=false，则只返回表名，但不会将$table设置为当前表

### insert

`insert($arr)`

插入数据，以数组的形式提供数据，数组的键名对应数据库的字段名，成功返回结果对象集，失败返回flase

> 必须使用table()指定要插入的表

```
$db->table("log");

$log1=array(
  'user'=>"u1",
  'message'=>"something"
  );
$log2=array(
  'user'=>"u2",
  'message'=>"msg for u2"
  );  

$db->insert($log1);
$db->insert($log2);
```

> 批量插入可以使用 insert_array($arr)

### q

`q($sql)`

执行完整的sql查询，$sql为完整的查询语句，可执行任意合法的语句

> 语句中可以使用`{table}`引用由table()定义的当前表
> 语句中可以使用`{prefix}`引用表前缀
> 参数传递推荐使用变量绑定方式


```
$db->table("log");

$db->q("select * from {table} where `id`=?",1);

$sqls=<<<SQL
update `{perfix}.user` set
 `username`=:username,
 `email`=:email
 where
 `uid`=:uid
SQL;

$db->q($sqls,array(
  'uid'=>1,
  'username'=>'u1',
  'email'=>'email@email.com'
  ));

```

### select

`select($col='*',$where='')`

快速查询，$col为需要查询的字段，提供以逗号分割的字段列表，$where为查询条件，sql语句WHERE后的部分，$where为空则查询所有记录

> 查询语句中可以使用变量绑定来传递参数，具体参考 变量绑定 章节
> $col不能使用字段别名，函数，若要使用这些功能，请使用q()

```
$db->table("user");

$db->select('uid,username,email','`uid`=?',$uid);

$user_info=$db->one();
print_r($user_info);
```

### has

`has($where)`

返回满足$where条件的记录的数量

```
$db->table("user");
$result=$db->has('`username`=?',$username);
if ($result){
  echo "用户名已经存在";
}

```

### count

`count()`

返回结果集中的记录数

```
$db->table("user");

$db->select();

print_r($db->count());
```

### lastid

`lastid()`

返回最后一次插入的id值

```
$db->table("log");
$db->insert(array(
  'user'=>"u1",
  'message'=>"something"
  ));
print_r($db->lastid());
```

### delete

`delete($where)`

删除满足$where条件的记录

```
$db->table("user");
$db->delete("`username`=?","user1");
```

### update

`update($arr,$where='')`

使用$arr数组更新满足$where条件的记录

$arr为字符索引的数组，其中键名对应数据库字段名

```
$db->table("user");

$userinfo=array(
  'email'=>"new@email.com"
  );

$db->update($userinfo,'`uid`=?',$uid);  

```

### replace

`replace($arr)`

使用$arr数组插入新记录，若记录已经存在则更新记录

> 表中必须存在主键，并且$arr数组中必须存在主键，才能触发更新

```
$db->table("log");

$log=array(
  'id'=>1
  'user'=>"u1",
  'message'=>"something"
  );

$db->replace($log);

```

### insert_array

`insert_array($arr)`

批量插入数据，$arr为一个二维数组，$arr中的每一个元素为一条要插入的数据

> insert_array类似于循环调用insert($arr)，不同的是使用insert_array只会在所有数据插入完成后进行一次commit，所以适合批量插入的场景
> $arr中的数组结构必须相同，否则会引发错误

```
$data=array(
  array(
    'id'=>1,
    'name'=>"u1"
    ),
  array(
    'id'=>2,
    'name'=>"u2"
    ),  
  array(
    'id'=>3,
    'name'=>"u2"
    ),
  );

$db->table("user");
$db->insert_array($data);
```

### replace_array

`replace_array($arr)`

作用与用法同insert_array()，区别在于replace_array()会判断记录是否存在，若存在则更新，不存在则插入，对插入数据的要求同replace()


### make_global

`make_global()`

查询结果处理，将查询结果根据字段名映射为php的全局变量，可以直接使用

```
$db->table("user");

$db->select('uid,username,email','`uid`=?',1);

$db->make_global();

print_r($uid);
print_r($username);
print_r($email);

```
> 如果结果集中有多条记录，只处理第一条

### one

`one($result='')`

从结果集中取出一条记录，返回以字段名为键值的一维数组

> 如果结果集内不止一条记录，则取第一条
> 若不传入结果集$result，则默认使用上次查询的结果集

```
$db->table("user");

$db->select('uid,username,email','`uid`=?',$uid);

$user_info=$db->one();
print_r($user_info);
```

### arr

`arr($result='')`

从查询结果集中取出所有记录，生成二维数组并返回，格式为`$result[行][字段]`

```
$db->table("user");

$db->select('uid,username,email');

$users=$db->arr();

foreach($users as $user){
  print_r($user['username']);
}

```
