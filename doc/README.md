# 基本用法

FPPDO对常用数据库功能进行了二次封装，兼具简便和灵活性

## 方法

|      名称       |          作用        .          |
| --------------- | ------------------------------- |
| debug()         | 开启调试输出，会输出对应sql语句 |
| q()             | 通用查询                        |
| v()             | 格式化参数，防注入              |
| v_arr()         | 格式化数组形式的参数            |
| prefix()        | 设置表前缀                      |
| gettable()      | 获取当前使用的表                |
| table()         | 设置当前使用的表                |
| one()           | 获取一条结果                    |
| arr()           | 获取结果数组                    |
| count()         | 获取结果行数                    |
| has()           | 表中是否有相应记录              |
| make_global()   | 根据结果生成全局变量            |
| lastid()        | 获取最后一次插入的id            |
| insert()        | 插入数据                        |
| select()        | 快速查询                        |
| delete()        | 删除数据                        |
| update()        | 更新数据                        |
| replace()       | 替换数据                        |
| insert_array()  | 批量插入数据                    |
| replace_array() | 批量替换数据                    |



详情参考：[FPPDO](FPPDO.md)

## 扩展类

扩展类是根据不同的数据库类型，以FPPDO为基类，增加数据库基本设置功能

### MySQL

[MySQL](MySQL.md)

### MSSQL

[MSSQL](MSSQL.md)

### SQLite

[SQLite](SQLite.md)
