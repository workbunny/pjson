## 文档说明

### 安装

```bash
composer require workbunny/pjson
```

### 引入

```php
// 引入 Composer 自动加载文件,根据你的实际情况修改路径
require './vendor/autoload.php';

use Workbunny\PJson\Json; // 解析json
use Workbunny\PJson\Arr; //json_arr对象处理
use Workbunny\PJson\Obj; //json_obj对象处理
use Workbunny\PJson\Val; //json_val对象处理
use Workbunny\PJson\Init; //json初始化处理
```

### 类型使用

[Json](Json.md) `Json::xxx(mixed)`

[Val](Val.md) `Val::xxx(mixed)`

[Arr](Arr.md) `Arr::xxx(mixed)`

[Obj](Obj.md) `Obj::xxx(mixed)`

[Init](Init.md) `Init::xxx(mixed)`

### 示例1

解析json字符串 并且获取值

```php
// 解析json字符串，返回json_val对象
$json_val = Json::parse_str('{"name":"workbunny","age":18,"isMan":true,"hobby":["reading","coding","traveling"],"address":{"city":"Shanghai","country":"China"}}');

/* 下面是直接获取 */
// 获取 字符串值
$name = Json::getStr($json_val,"name"); // workbunny
// 获取 数字值
$age = Json::getNum($json_val,"age"); // 18
// 获取 布尔值
$isMan = Json::getBool($json_val,"isMan"); // true
// 获取 数组值
$hobby = Json::getArr($json_val,"hobby"); // 这个是一个json_arr对象，不能直接输出结果
// 获取 对象值
$address = Json::getObj($json_val,"address"); // 这个是一个json_obj对象，不能直接输出结果

/* 下面是嵌套获取 */
// 获取 字符串值
$city = Json::getStr($json_val,"address.city"); // 结果是：Shanghai，使用点号来分隔层级 
$coding = Json::getStr($json_val,"hobby.1"); // 结果是：coding，使用点号来分隔层级
/* 以此类推 */

```
