# JSON 核心

`use Workbunny\PJson\Type;`

### 当前版本号 `version()`

- `static` 函数
- `return` 字符串

```php
// 获取当前版本号
$version = Json::version();
echo "当前版本号：{$version}\n";
// 当前版本号：v0.0.1
```

### 解析 JSON 字符串 `parse(string $json)`

- `static` 函数
- `param` `string` $json 字符串
- `return` `CData` JSON对象

```php
// 解析 JSON 字符串
$json_str = '{"name":"John", "age":30, "city":"New York"}';
$json_obj = Json::parse($json_str);
```

### 创建 JSON 对象 `create(mixed $root)`

- `static` 函数
- `param` `mixed` $root 内容
- `return` `CData` JSON对象

```php
// 创建 JSON 对象
$null = Json::create(null);
$bool = Json::create(true);
$str = Json::create("Hello, World!");
$int = Json::create(123);
$float = Json::create(123.45);
$default_array = Json::create([]);
$array = Json::create(['name', 'John', 'age', 30]);
$default_object = Json::create((object)[]);
$object = Json::create((object)['name' => 'John', 'age' => 30]);

var_dump(Json::val($null)); // null
var_dump(Json::val($bool)); // bool(true)
var_dump(Json::val($str)); // string(13) "Hello, World!"
var_dump(Json::val($int)); // int(123)
var_dump(Json::val($float)); // float(123.45)
// var_dump(Json::val($default_array)); // json数组 和json对象类型 会报错，不能直接使用
var_dump(Json::print($default_array)); // "[]"
var_dump(Json::print($array)); // "["name","John","age",30]"
var_dump(Json::print($default_object)); // "{}"
var_dump(Json::print($object)); // "{"name":"John","age":30}"
```

### 获取 JSON 对象的值 `get(CData $jsonObj, string|int $key)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `string|integer` $key JSON 键、索引
- `return` `CData` JSON 对象

```php
// 获取 JSON 对象的值
$json_str = '{"name":"John", "age":30, "city":"New York"}';
$json_obj = Json::parse($json_str);
$name = Json::get($json_obj, 'name');
var_dump(Json::val($name)); // "John"
$age = Json::get($json_obj, 'age');
var_dump(Json::val($age)); // float(30)

$json_arr = '["name",30,"New York"]';
$json_arr_obj = Json::parse($json_arr);
$first = Json::get($json_arr_obj, 0);
var_dump(Json::val($first)); // "name"
$city = Json::get($json_arr_obj, 2);
var_dump(Json::val($city)); // "New York"
```

### 深度获取 JSON 对象的值 `deepGet(CData $jsonObj, string $pointer, bool $caseSensitive = true)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `string` $pointer 路径，必须以 / 开头 如：/abc/0/def
- `param` `boolean` $caseSensitive 是否区分大小写 默认：true
- `return` `CData` JSON 对象

```php
// 深度获取 JSON 对象的值
$json_str = '{"name":"John", "age":30, "address":{"city":"New York", "zip":"10001"}}';
$json_obj = Json::parse($json_str);
$city = Json::deepGet($json_obj, '/address/city');
var_dump(Json::val($city)); // "New York"
```

### 设置 JSON 对象的值 `set(CData $jsonObj, string|int|CData $key, CData $item)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `string|integer|CData` $key JSON 键、索引或者JSON对象
- `param` `CData` $item JSON 对象
- `return` `bool`

```php
// 设置 JSON 对象的值
$json_str1 = '{"name":"John", "age":30}';
$json_obj = Json::parse($json_str1);
Json::set($json_obj, 'name', Json::create('Jane'));
var_dump(Json::print($json_obj)); // "{"name":"Jane","age":30}"

$json_str1 = '["KingBes",30,"Guang Zhou"]';
$json_Arr = Json::parse($json_str1);
Json::set($json_Arr, 0, Json::create('Bunny'));
var_dump(Json::print($json_Arr)); // "["Bunny",30,"Guang Zhou"]"

$res = Json::set($json_Arr, Json::get($json_Arr, 2), Json::create("Bei Jing"));
var_dump($res); // bool(true) 修改成功
var_dump(Json::print($json_Arr)); // "["Bunny",30,"Bei Jing"]"
```

### 深度设置 JSON 对象的值 `deepSet(CData &$jsonObj, string $pointer, CData $item)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `string` $pointer 路径，必须以 / 开头 如：/abc/0/def
- `param` `CData` $item JSON 对象
- `return` `bool`

```php
// 深度设置 JSON 对象的值
$json_str = '{"name":"John", "age":30, "address":{"city":"New York", "zip":"10001"}}';
$json_obj = Json::parse($json_str);
$res = Json::deepSet($json_obj, '/address/city', Json::create('Guangzhou'));
var_dump($res); // bool(true) 修改成功
var_dump(Json::print($json_obj)); // "{"name":"John","age":30,"address":{"city":"Guangzhou","zip":"10001"}}"
```

### 添加 JSON 对象的值 `add(CData $jsonObj, string|CData $keyIntItem, ?CData $item = null)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `string|CData` $strOrItem JSON 键或JSON对象
- `param` `CData|null` $item JSON 对象
- `return` `boolean`

```php
// 添加 JSON 对象的值
$json_str = '{"name":"John", "age":30,"hobby":["basketball","football"]}';
$json_obj = Json::parse($json_str);
$res = Json::add($json_obj, 'address', Json::create(['city' => 'New York', 'zip' => '10001']));
var_dump($res); // bool(true) 添加成功
var_dump(Json::print($json_obj)); // "{"name":"John","age":30,"address":{"city":"New York","zip":"10001"}}" 

$json_Arr = '["name",30,"New York"]';
$json_Arr_obj = Json::parse($json_Arr);
$res = Json::add($json_Arr_obj, Json::create('Guangzhou'));
var_dump($res); // bool(true) 添加成功
var_dump(Json::print($json_Arr_obj)); // "["name",30,"New York","Guangzhou"]"
```

### 深度添加 JSON 对象的值 `deepAdd(CData &$jsonObj, string $pointer, CData $item)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `string` $pointer 路径，必须以 / 开头 如：/abc/0/def
- `param` `CData` $item JSON 对象
- `return` `boolean`

```php
// 深度添加 JSON 对象的值
$json_str = '{"name":"John", "age":30, "address":{"city":"New York", "zip":"10001"}}';
$json_obj = Json::parse($json_str);
$res = Json::deepAdd($json_obj, '/address/hobby', Json::create(['basketball', 'football']));
var_dump($res); // bool(true) 添加成功
var_dump(Json::print($json_obj)); // "{"name":"John","age":30,"address":{"city":"New York","zip":"10001","hobby":["basketball","football"]}}" */
```

### 删除 JSON 对象的值 `remove(CData $jsonObj, string|int|CData $item)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `string|integer|CData` $item JSON 键、索引或 JSON 对象
- `return` `void`

```php
// 删除 JSON 对象的值
$json_str = '{"name":"John", "age":30, "address":{"city":"New York", "zip":"10001"}}';
$json_obj = Json::parse($json_str);
Json::remove($json_obj, 'age');
var_dump(Json::print($json_obj)); // "{"name":"John","address":{"city":"New York","zip":"10001"}}"
$address = Json::get($json_obj, 'address');
Json::remove($json_obj, $address);
var_dump(Json::print($json_obj)); // "{"name":"John"}"

$json_Arr = '["name",30,"New York"]';
$json_Arr_obj = Json::parse($json_Arr);
Json::remove($json_Arr_obj, 1);
var_dump(Json::print($json_Arr_obj)); // "["name","New York"]"
```

### 深度删除 JSON 对象的值 `deepRemove(CData &$jsonObj, string $pointer)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `string` $pointer 路径，必须以 / 开头 如：/abc/0/def
- `return` `void`

```php
// 深度删除 JSON 对象的值
$json_str = '{"name":"John", "age":30, "address":{"city":"New York", "zip":"10001"}}';
$json_obj = Json::parse($json_str);
Json::deepRemove($json_obj, '/address/city');
var_dump(Json::print($json_obj)); // "{"name":"John","age":30,"address":{"zip":"10001"}}"
```

### 复制 JSON 对象 `copy(CData $jsonObj, bool $deep = true)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `boolean` $deep 是否深度复制 true（递归复制所有子节点） false（仅复制当前节点，子节点指向原数据）
- `return` `CData` 新的 JSON 对象

```php
// 复制 JSON 对象
$json_str = '{"name":"John", "age":30, "address":{"city":"New York", "zip":"10001"}}';
$json_obj = Json::parse($json_str);
$copy_obj = Json::copy($json_obj);
$new_obj = $json_obj; // 失败复制

$res = Json::set($json_obj, 'name', Json::create('Jane')); 
var_dump($res); // bool(true) 修改成功
var_dump(Json::print($json_obj)); // "{"name":"Jane","age":30,"address":{"city":"New York","zip":"10001"}}"
var_dump(Json::print($copy_obj)); // "{"name":"John","age":30,"address":{"city":"New York","zip":"10001"}}"
var_dump(Json::print($new_obj)); // "{"name":"Jane","age":30,"address":{"city":"New York","zip":"10001"}}"
```

### 合并两个 JSON 对象 `merge(CData $jsonObj1, CData $jsonObj2, bool $caseSensitive = true)`

- `static` 函数
- `param` `CData` $jsonObj1 第一个 JSON 对象
- `param` `CData` $jsonObj2 第二个 JSON 对象
- `param` `boolean` $caseSensitive 是否区分大小写 默认：true
- `return` `CData` 合并后的 JSON 对象

```php
// 合并两个 JSON 对象
$json_obj1 = Json::parse('{
    "name": "Alice",
    "age": 25,
    "active": true,
    "address": {"city": "Beijing", "zipcode": "100000"},
    "hobbies": ["reading", "music"]
}');

/* {
    "age": 30,  // 更新数值
    "active": false, // 更新布尔值
    "address": {
        "city": "Shanghai", 
        "country": "China" // 新增字段
    },
    "hobbies": null // 删除 hobbies 字段
} */
$json_obj2 = Json::parse('
{
    "age": 30,
    "active": false,
    "address": {
        "city": "Shanghai", 
        "country": "China"
    },
    "hobbies": null
}');
$new_obj = Json::merge($json_obj1, $json_obj2, true);
var_dump(Json::print($json_obj1));
var_dump(Json::print($json_obj2));
var_dump(Json::print($new_obj)); // 合并后的结果
/* {
    "name": "Alice",
    "age":  30,
    "active":       false,
    "address":      {
            "zipcode":      "100000",
            "city": "Shanghai",
            "country":      "China"
    }
} */
```

### 比较两个 JSON 对象是否相等 `compare(CData $jsonObj1, CData $jsonObj2, bool $caseSensitive = false)`

- `static` 函数
- `param` `CData` $jsonObj1 第一个 JSON 对象
- `param` `CData` $jsonObj2 第二个 JSON 对象
- `param` `boolean` $caseSensitive 是否区分大小写 默认：false

```php
// 比较两个 JSON 对象是否相等
$json_obj1 = Json::parse('{"name":"Alice","age":25}');
$json_obj2 = Json::parse('{"name":"Alice","age":25}');
$json_obj3 = Json::parse('{"name":"Bob","age":30}');
$json_obj4 = Json::parse('{"NAME":"Bob","age":30}');

$bool1 = Json::compare($json_obj1, $json_obj2);
$bool2 = Json::compare($json_obj1, $json_obj3);
$bool3 = Json::compare($json_obj1, $json_obj4, true);

var_dump($bool1); // bool(true)
var_dump($bool2); // bool(false)
var_dump($bool3); // bool(false)
```

### 检查 JSON 对象是否包含指定键 `hasKey(CData $jsonObj, string $key)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `string` $key JSON 键
- `return` `boolean`

```php
// 检查 JSON 对象是否包含指定键
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
$has_name = Json::hasKey($json_obj, 'name');
$has_site = Json::hasKey($json_obj, 'site');
var_dump($has_name); // bool(true)
var_dump($has_site); // bool(false)
```

### JSON 对象转PHP类型 `val(CData $jsonObj)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `return` `mixed`

```php
// JSON 对象转PHP类型
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
$json_str = Json::parse('"hello world"');
$json_arr = Json::parse('["name",30,"New York"]');
$json_num = Json::parse('123');
// var_dump(Json::val($json_obj)); // 报错
var_dump(Json::val($json_str)); // string(11) "hello world"
// var_dump(Json::val($json_arr)); // 报错
var_dump(Json::val($json_num)); // float(123)
```

### 获取 JSON 对象的长度 `count(CData $jsonObj)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `return` `integer` 长度

```php
// 获取 JSON 对象的长度
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
var_dump(Json::count($json_obj)); // 3
$json_Arr = Json::parse('["name",30,"New York"]');
var_dump(Json::count($json_Arr)); // 3
```

### 检查 JSON 对象的类型 `check(CData $jsonObj)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `return` `string` 类型

```php
// 检查 JSON 对象的类型
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
$json_str = Json::parse('"hello world"');
$json_arr = Json::parse('["name",30,"New York"]');
$json_num = Json::parse('123');
$json_bool = Json::parse('true');
var_dump(Json::check($json_obj)); // string(6) "OBJECT"
var_dump(Json::check($json_str)); // string(6) "STRING"
var_dump(Json::check($json_arr)); // string(5) "ARRAY"
var_dump(Json::check($json_num)); // string(6) "NUMBER"
var_dump(Json::check($json_bool)); // string(4) "TRUE"
```

### 获取 JSON 对象的路径 `pointerPath(CData $jsonObj, CData $item)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `CData` $item JSON 对象
- `return` `string` 路径

```php
// 获取 JSON 对象的路径
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
$address = Json::get($json_obj, 'address');
$city = Json::get($address, 'city');
$path = Json::pointerPath($json_obj, $city);
var_dump($path); // "/address/city"
```

### 排序 JSON 对象 `sort(CData $jsonObj, bool $caseSensitive = true)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `boolean` $caseSensitive 是否区分大小写 默认：true
- `return` `void`

```php
// 排序 JSON 对象
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
Json::sort($json_obj, true); // true区分大小写
var_dump(Json::print($json_obj)); // "{"address":{"city":"Beijing"},"age":25,"name":"Alice"}"
```

### 删除 JSON 对象 `delete(CData $jsonObj)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `return` `void`

```php
// 删除 JSON 对象
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
Json::delete($json_obj);
var_dump(Json::print($json_obj)); // 报错：已被删除
```

### 将 JSON 对象转换为 JSON 字符串 `print(CData $jsonObj, bool $isFormat = true)`

- `static` 函数
- `param` `CData` $jsonObj JSON 对象
- `param` `boolean` $isFormat 是否格式化输出 默认为 true
- `return` `string`

```php
// 将 JSON 对象转换为 JSON 字符串
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
$str = Json::print($json_obj);
var_dump($str); // string(50) "{"name":"Alice","age":25,"address":{"city":"Beijing"}}"
```