<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Workbunny\PJson\Json;
use Workbunny\PJson\Type;

/* // 获取当前版本号
$version = Json::version();
echo "当前版本号：{$version}\n"; */

/* // 解析 JSON 字符串
$json_str = '{"name":"John", "age":30, "city":"New York"}';
$json_obj = Json::parse($json_str); */

/* // 创建 JSON 对象
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
var_dump(Json::print($default_array)); // string(2) "[]"
var_dump(Json::print($array)); // string(24) "["name","John","age",30]"
var_dump(Json::print($default_object)); // string(3) "{ }"
var_dump(Json::print($object)); // string(24) "{"name":"John","age":30}" */

/* // 获取 JSON 对象的值
$json_str = '{"name":"John", "age":30, "city":"New York"}';
$json_obj = Json::parse($json_str);
$name = Json::get($json_obj, 'name');
var_dump(Json::val($name)); // string(4) "John"
$age = Json::get($json_obj, 'age');
var_dump(Json::val($age)); // float(30)

$json_arr = '["name",30,"New York"]';
$json_arr_obj = Json::parse($json_arr);
$first = Json::get($json_arr_obj, 0);
var_dump(Json::val($first)); // string(4) "name"
$city = Json::get($json_arr_obj, 2);
var_dump(Json::val($city)); // string(8) "New York" */

/* // 深度获取 JSON 对象的值
$json_str = '{"name":"John", "age":30, "address":{"city":"New York", "zip":"10001"}}';
$json_obj = Json::parse($json_str);
$city = Json::deepGet($json_obj, '/address/city');
var_dump(Json::val($city)); // string(8) "New York" */

/* // 设置 JSON 对象的值
$json_str1 = '{"name":"John", "age":30}';
$json_obj = Json::parse($json_str1);
Json::set($json_obj, 'name', Json::create('Jane'));
var_dump(Json::print($json_obj)); // string(26) "{"name":"Jane","age":30}"

$json_str1 = '["KingBes",30,"Guang Zhou"]';
$json_Arr = Json::parse($json_str1);
Json::set($json_Arr, 0, Json::create('Bunny'));
var_dump(Json::print($json_Arr)); // string(18) "["Bunny",30,"Guang Zhou"]"
$res = Json::set($json_Arr, Json::get($json_Arr, 2), Json::create("Bei Jing"));
var_dump($res); // bool(true) 修改成功
var_dump(Json::print($json_Arr)); // string(18) "["Bunny",30,"Bei Jing"]" */

/* // 深度设置 JSON 对象的值
$json_str = '{"name":"John", "age":30, "address":{"city":"New York", "zip":"10001"}}';
$json_obj = Json::parse($json_str);
$res = Json::deepSet($json_obj, '/address/city', Json::create('Guangzhou'));
var_dump($res); // bool(true) 修改成功
var_dump(Json::print($json_obj)); // string(50) "{"name":"John","age":30,"address":{"city":"Guangzhou","zip":"10001"}}" */

/* // 添加 JSON 对象的值
$json_str = '{"name":"John", "age":30,"hobby":["basketball","football"]}';
$json_obj = Json::parse($json_str);
$res = Json::add($json_obj, 'address', Json::create(['city' => 'New York', 'zip' => '10001']));
var_dump($res); // bool(true) 添加成功
var_dump(Json::print($json_obj)); // string(66) "{"name":"John","age":30,"address":{"city":"New York","zip":"10001"}}" 

$json_Arr = '["name",30,"New York"]';
$json_Arr_obj = Json::parse($json_Arr);
$res = Json::add($json_Arr_obj, Json::create('Guangzhou'));
var_dump($res); // bool(true) 添加成功
var_dump(Json::print($json_Arr_obj)); // string(34) "["name",30,"New York","Guangzhou"]" */

/* // 深度添加 JSON 对象的值
$json_str = '{"name":"John", "age":30, "address":{"city":"New York", "zip":"10001"}}';
$json_obj = Json::parse($json_str);
$res = Json::deepAdd($json_obj, '/address/hobby', Json::create(['basketball', 'football']));
var_dump($res); // bool(true) 添加成功
var_dump(Json::print($json_obj)); // string(82) "{"name":"John","age":30,"address":{"city":"New York","zip":"10001","hobby":["basketball","football"]}}" */

/* // 删除 JSON 对象的值
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
var_dump(Json::print($json_Arr_obj)); // "["name","New York"]" */

/* // 深度删除 JSON 对象的值
$json_str = '{"name":"John", "age":30, "address":{"city":"New York", "zip":"10001"}}';
$json_obj = Json::parse($json_str);
Json::deepRemove($json_obj, '/address/city');
var_dump(Json::print($json_obj)); // "{"name":"John","age":30,"address":{"zip":"10001"}}" */

/* // 复制 JSON 对象
$json_str = '{"name":"John", "age":30, "address":{"city":"New York", "zip":"10001"}}';
$json_obj = Json::parse($json_str);
$copy_obj = Json::copy($json_obj);
$new_obj = $json_obj; // 失败复制

$res = Json::set($json_obj, 'name', Json::create('Jane')); 
var_dump($res); // bool(true) 修改成功
var_dump(Json::print($json_obj)); // "{"name":"Jane","age":30,"address":{"city":"New York","zip":"10001"}}"
var_dump(Json::print($copy_obj)); // "{"name":"John","age":30,"address":{"city":"New York","zip":"10001"}}"
var_dump(Json::print($new_obj)); // "{"name":"Jane","age":30,"address":{"city":"New York","zip":"10001"}}" */

// // 合并两个 JSON 对象
// $json_obj1 = Json::parse('{
//     "name": "Alice",
//     "age": 25,
//     "active": true,
//     "address": {"city": "Beijing", "zipcode": "100000"},
//     "hobbies": ["reading", "music"]
// }');

// /* {
//     "age": 30,  // 更新数值
//     "active": false, // 更新布尔值
//     "address": {
//         "city": "Shanghai", 
//         "country": "China" // 新增字段
//     },
//     "hobbies": null // 删除 hobbies 字段
// } */
// $json_obj2 = Json::parse('
// {
//     "age": 30,
//     "active": false,
//     "address": {
//         "city": "Shanghai", 
//         "country": "China"
//     },
//     "hobbies": null
// }');
// $new_obj = Json::merge($json_obj1, $json_obj2, true);
// var_dump(Json::print($json_obj1));
// var_dump(Json::print($json_obj2));
// var_dump(Json::print($new_obj)); // 合并后的结果
// /* {
//     "name": "Alice",
//     "age":  30,
//     "active":       false,
//     "address":      {
//             "zipcode":      "100000",
//             "city": "Shanghai",
//             "country":      "China"
//     }
// } */

/* // 比较两个 JSON 对象是否相等
$json_obj1 = Json::parse('{"name":"Alice","age":25}');
$json_obj2 = Json::parse('{"name":"Alice","age":25}');
$json_obj3 = Json::parse('{"name":"Bob","age":30}');
$json_obj4 = Json::parse('{"NAME":"Bob","age":30}');

$bool1 = Json::compare($json_obj1, $json_obj2);
$bool2 = Json::compare($json_obj1, $json_obj3);
$bool3 = Json::compare($json_obj1, $json_obj4, true);

var_dump($bool1); // bool(true)
var_dump($bool2); // bool(false)
var_dump($bool3); // bool(false) */

/* // 检查 JSON 对象是否包含指定键
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
$has_name = Json::hasKey($json_obj, 'name');
$has_site = Json::hasKey($json_obj, 'site');
var_dump($has_name); // bool(true)
var_dump($has_site); // bool(false) */

/* // JSON 对象转PHP类型
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
$json_str = Json::parse('"hello world"');
$json_arr = Json::parse('["name",30,"New York"]');
$json_num = Json::parse('123');
// var_dump(Json::val($json_obj)); // 报错
var_dump(Json::val($json_str)); // string(11) "hello world"
// var_dump(Json::val($json_arr)); // 报错
var_dump(Json::val($json_num)); // float(123) */

/* // 获取 JSON 对象的长度
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
var_dump(Json::count($json_obj)); // 3
$json_Arr = Json::parse('["name",30,"New York"]');
var_dump(Json::count($json_Arr)); // 3 */

/* // 检查 JSON 对象的类型
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
$json_str = Json::parse('"hello world"');
$json_arr = Json::parse('["name",30,"New York"]');
$json_num = Json::parse('123');
$json_bool = Json::parse('true');
var_dump(Json::check($json_obj)); // string(6) "OBJECT"
var_dump(Json::check($json_str)); // string(6) "STRING"
var_dump(Json::check($json_arr)); // string(5) "ARRAY"
var_dump(Json::check($json_num)); // string(6) "NUMBER"
var_dump(Json::check($json_bool)); // string(4) "TRUE" */

/* // 获取 JSON 对象的路径
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
$address = Json::get($json_obj, 'address');
$city = Json::get($address, 'city');
$path = Json::pointerPath($json_obj, $city);
var_dump($path); // "/address/city" */

/* // 排序 JSON 对象
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
Json::sort($json_obj, true); // true区分大小写
var_dump(Json::print($json_obj)); // "{"address":{"city":"Beijing"},"age":25,"name":"Alice"}" */

/* // 删除 JSON 对象
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
Json::delete($json_obj);
var_dump(Json::print($json_obj)); // 报错：已被删除 */

/* // 压缩 JSON 字符串 (没用)
$json_str = '{"name":  "Alice","age":  25,  "address":  {"city":  "Beijing"}}';
var_dump($json_str);
Json::minify($json_str);
var_dump($json_str); */

// 将 JSON 对象转换为 JSON 字符串
$json_obj = Json::parse('{"name":"Alice","age":25,"address":{"city":"Beijing"}}');
$str = Json::print($json_obj);
var_dump($str); // string(50) "{"name":"Alice","age":25,"address":{"city":"Beijing"}}"