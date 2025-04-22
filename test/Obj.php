<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Workbunny\PJson\Json;
use Workbunny\PJson\Val;
use Workbunny\PJson\Arr;
use Workbunny\PJson\Obj;

function formatBytes($bytes)
{
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = 0;
    while ($bytes >= 1024 && $i < 3) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . $units[$i];
}

$start = microtime(true);

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

// 追加 json_obj对象的值
Obj::setStr($address,"city2","Beijing");
/* 以此类推 */

// 删除 json_obj对象的值
Obj::remove($address,"city"); // 删除city的值
/* 以此类推 */

$json_obj_val = Obj::toVal($address); // 这个是一个json_val对象，不能直接输出结果

// 序列号化json_val对象为字符串
echo Json::serialize($json_obj_val)."\n";

/*结果： {
    "city2": "Beijing",
    "country": "China"
} */

// 占用内存
$current_memory = memory_get_usage();
echo "当前内存占用: " . formatBytes($current_memory) . "\n";


$end = microtime(true); // 记录结束时间
$time = $end - $start;  // 计算总耗时（单位：秒）
echo "执行耗时: " . round($time, 4) . " 秒";