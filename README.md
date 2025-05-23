# pjson
✨ PJson 用于解析 JSON 数据并提供高效的内存管理优化。

## 依赖

- PHP 8.1 或更高版本
- Composer 2.0 或更高版本
- PHP 扩展 `ffi` 已启用
- linux 系统
- windows 系统
- mac 系统(自己执沙) 

## 安装

```bash
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
当前内存：2.35MB
【原生PHP JSON】 (迭代：1 次)
总耗时：0.00311589 秒
每次平均耗时：0.00311589 秒
内存变化：32B
```

pjson

```php
// pjson解析
$json = Json::parse($json_str);
$type = Json::get($json, 'type');
var_dump(Json::val($type));
```

```
当前内存：733.2KB
【PJson JSON】 (迭代：1 次)
总耗时：0.00883102 秒
每次平均耗时：0.00883102 秒
内存变化：114.81KB
```

## 编译json动态库

编译适合自己系统的动态库

`build` 文件夹

```bash
tcc -shared cJSON.c cJSON_Utils.c -o ../lib/Json.dll
```
