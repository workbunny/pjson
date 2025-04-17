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

$type = Obj::getStr($json, 'type');

var_dump($type);

// 占用内存
$current_memory = memory_get_usage();
echo "当前内存占用: " . formatBytes($current_memory) . "\n";


$end = microtime(true); // 记录结束时间
$time = $end - $start;  // 计算总耗时（单位：秒）
echo "执行耗时: " . round($time, 4) . " 秒";
