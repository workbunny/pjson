<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Workbunny\PJson\Json;
use Workbunny\PJson\Arr;
use Workbunny\PJson\Obj;

// 中国地区编码json
// https://geo.datav.aliyun.com/areas_v3/bound/100000.json


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

// json文件内容
$json_str = file_get_contents("https://geo.datav.aliyun.com/areas_v3/bound/100000.json");

$start = microtime(true);

// pjson解析
$json = Json::decode($json_str);
// 获取数组
$arr = Obj::getArr($json, 'features');
// 获取数组的第一个元素
$arr0 = Arr::getObj($arr, 0);
// 获取数组的第一个元素的属性值
$type = Obj::DotgetStr($arr0, 'properties.name');

var_dump($type);

// 占用内存
$current_memory = memory_get_usage();
echo "当前内存占用: " . formatBytes($current_memory) . "\n";


$end = microtime(true); // 记录结束时间
$time = $end - $start;  // 计算总耗时（单位：秒）
echo "执行耗时: " . round($time, 4) . " 秒";
