# MSSQL

MSSQL基于FPPDO，提供了对微软SQL Server的配置管理和连接管理功能，其他功能同[FPPDO](FPPDO.md)

## 配置

创建`$DB_MSSQL`全局变量，包含配置信息

|  名称   |                   说明                    |
| ------- | ----------------------------------------- |
| id      | 配置id，可以是字符串，唯一                |
| desc    | 说明                                      |
| server  | 服务器地址                                |
| port    | 服务器端口                                |
| user    | 用户名                                    |
| passwd  | 密码                                      |
| db      | 使用的数据库                              |
| charset | 默认字符集                                |
| prefix  | 表前缀                                    |
| driver  | 使用的驱动，默认`dblib`，windows下使用`mssql` |
| options | 数组，附加配置，参考PDO的option           |


```
$DB_MSSQL=array(
	array(
		'id'=>'1',
		'desc'=>'主数据库',
		'server' => 'localhost',
    'port' => 3306,
		'user' => 'root',
		'passwd' => 'root',
		'db' => '',
		'charset' => 'utf8',
    'prefix' => '',
		'driver'=>'dblib',
		'options'=>array(),
	),

);
```

若同时使用多个数据库，可通过配置id进行区分

## 使用

通过MSSQL的静态方法open()方法取得一个数据库连接实例，若之前已经存在连接，则复用连接

不想复用已存在的连接，可直接通过构造函数创建新的MSSQL对象

可通过传递配置id来指定连接的数据库，若不指定，则默认连接配置中第一个数据库

```
$db=MSSQL::open();//使用默认数据库

$db=MSSQL::open("2");//使用id为2的数据库

$db=new MSSQL("2");//使用id为2的数据库，创建新连接

```
