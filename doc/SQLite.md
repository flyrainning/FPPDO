# SQLite

SQLite基于FPPDO，提供了对SQLite数据库的配置管理和连接管理功能，其他功能同[FPPDO](FPPDO.md)

## 配置

创建`$DB_SQLite`全局变量，包含配置信息

|  名称   |              说明               |
| ------- | ------------------------------- |
| id      | 配置id，可以是字符串，唯一      |
| desc    | 说明                            |
| file    | 数据库文件，为空使用内存数据库  |
| prefix  | 表前缀                          |
| options | 数组，附加配置，参考PDO的option |


```
$DB_SQLite=array(
  array(
    'id'=>'1',
    'desc'=>'主数据库',
    'file' => '',//file为空，使用内存数据库
    'prefix' => '',
    'options'=>array(),
  ),
);
```

若同时使用多个数据库，可通过配置id进行区分

## 使用

通过MySQL的静态方法open()方法取得一个数据库连接实例，若之前已经存在连接，则复用连接

不想复用已存在的连接，可直接通过构造函数创建新的MySQL对象

可通过传递配置id来指定连接的数据库，若不指定，则默认连接配置中第一个数据库

```
$db=MySQL::open();//使用默认数据库

$db=MySQL::open("2");//使用id为2的数据库

$db=new MySQL("2");//使用id为2的数据库，创建新连接

```

可传入第二个参数，指定一段sql语句，该语句会在数据库初始化的时候被调用，这在使用内存数据库时很有用，可用来初始化相关表

```
$DB_SQLite=array(
  array(
    'id'=>'1',
    'desc'=>'主数据库',
    'file' => '',//file为空，使用内存数据库
    'prefix' => '',
    'options'=>array(),
  ),
);


$init_sql=<<<CODE
CREATE TABLE `newtable` (
	`Field1`	INTEGER,
	`Field2`	TEXT,
	`Field3`	BLOB,
	`Field4`	REAL,
	`Field5`	NUMERIC
);
CODE;
$db=SQLite::open('',$init_sql);

```
