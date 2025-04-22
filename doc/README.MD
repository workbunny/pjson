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

// 序列号化json_val对象为字符串
echo Json::serialize($json_val);

```

### 示例2

解析json字符串 并且对json_arr对象进行操作

```php
// 解析json字符串，返回json_val对象
$json_val = Json::parse_str('{"name":"workbunny","age":18,"isMan":true,"hobby":["reading","coding","traveling"],"address":{"city":"Shanghai","country":"China"}}');

// 获取 数组值
$hobby = Json::getArr($json_val,"hobby"); // 这个是一个json_arr对象，不能直接输出结果

// 获取 数组长度
$hobby_len = Arr::getCount($hobby); // 3

// 获取 数组元素
$coding = Arr::getStr($hobby,1); // 结果是：coding
/* 以此类推 */

// 修改 数组元素
Arr::setBool($hobby,1,false); // 将第二个元素修改为false
/* 以此类推 */

// 追加 数组元素
Arr::appendStr($hobby,"swimming"); // 在数组末尾追加一个元素
/* 以此类推 */

// 删除 数组元素
Arr::remove($hobby, 0); // 删除第一个元素
/* 以此类推 */

// 将json_arr对象转换为json_val对象
$json_val = Arr::toVal($hobby); // 这个是一个json_val对象，不能直接输出结果

// 序列号化json_val对象为字符串
echo Json::serialize($json_val);

/*结果： [
    "reading",
    false,
    "traveling",
    "swimming"
] */

```

### 示例3

解析json字符串 并且对json_obj对象进行操作

```php
// 解析json字符串，返回json_val对象
$json_val = Json::parse_str('{"name":"workbunny","age":18,"isMan":true,"hobby":["reading","coding","traveling"],"address":{"city":"Shanghai","country":"China"}}');


// 获取 对象值
$address = Json::getObj($json_val,"address"); // 这个是一个json_obj对象，不能直接输出结果

// 获取 json_obj对象的值
$city = Obj::getStr($address,"city"); // 结果是：Shanghai
/* 以此类推 */

// 修改 json_obj对象的值
Obj::setStr($address,"city","Beijing"); // 将city的值修改为Beijing
/* 以此类推 */

```