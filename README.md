# FPPDO

基于PHP的PDO驱动的再次封装，简化常用数据库操作

# 迁移通知

因中国国内部分地区访问github存在网络问题，我们不得不将该项目迁移到国内进行维护

本仓库停止更新

最新版本：[https://gitee.com/flyrainning/FPPDO](https://gitee.com/flyrainning/FPPDO)


## 安装和使用

在页面中引入FPPDO.php，使用PDO连接字符串创建连接

```
<?php
require "class/FPPDO.php";
$db=new FPPDO($dsn, $user, $passwd,$options);
?>
```

PDO根据不同的连接字符串，可以支持不同的数据库，针对不同的数据库以FPPDO为基类创建对应的连接库，以适应不同项目的需求

## 文档

[PDO Doc](doc/)
