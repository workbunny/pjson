<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Workbunny\PJson\Json;
use Workbunny\PJson\Val;
use Workbunny\PJson\Arr;
use Workbunny\PJson\Obj;

// 解析json字符串，返回json_val对象
$json_val = Json::parse_str('{"name":"workbunny","age":18,"isMan":true,"hobby":["reading","coding","traveling"],"address":{"city":"Shanghai","country":"China"}}');

// 获取 数组值
$hobby = Json::getArr($json_val, "hobby"); // 这个是一个json_arr对象，不能直接输出结果

// 获取 数组长度
$hobby_len = Arr::getCount($hobby); // 3

// 获取 数组元素
$coding = Arr::getStr($hobby, 1); // 结果是：coding
/* 以此类推 */

// 修改 数组元素
Arr::setBool($hobby, 1, false); // 将第二个元素修改为false
/* 以此类推 */

// 追加 数组元素
Arr::appendStr($hobby, "swimming"); // 在数组末尾追加一个元素
/* 以此类推 */

// 将json_arr对象转换为json_val对象
$json_val = Arr::toVal($hobby); // 这个是一个json_val对象，不能直接输出结果

// 序列号化json_val对象为字符串
echo Json::serialize($json_val);

