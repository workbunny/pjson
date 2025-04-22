# pjson
✨ PJson 用于解析 JSON 数据并提供高效的内存管理优化。

## 依赖

- PHP 8.1 或更高版本
- Composer 2.0 或更高版本
- PHP 扩展 `ffi` 已启用
- linux 系统
- windows 系统
- mac 系统(暂未开启)

## 安装

```bash
# 暂未开启
composer require workbunny/pjson
```

## 如何使用

[文档](doc/README.MD)

## 测试对比结果

> 以此json为例 `https://geo.datav.aliyun.com/areas_v3/bound/100000.json`

php原生

```php
// 原生解析
$php_json = json_decode($json_str, true);
// 拿其中一个字段
$type = $php_json['type'];
var_dump($type);
```

```
当前内存占用: 2.25MB
执行耗时: 0.0042 秒
```

pjson

```php
// pjson解析
$json = Json::parse_str($json_str);
$type = Json::getStr($json, 'type');
var_dump($type);
```

```
当前内存占用: 572.92KB
执行耗时: 0.0137 秒
```

## 编译json动态库

编译适合自己系统的动态库

`build` 文件夹

```bash
gcc parson.c -shared -o Json.so -O2 -Wall -Wextra -std=c89 -pedantic-errors -DTESTS_MAIN 
```
