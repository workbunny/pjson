<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Workbunny\PJson\Json;

$start = microtime(true);

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

// 原生解析
// $php_json = json_decode($json_str, true);

// // 拿其中一个字段
// $type = $php_json['type']; // 占用内存：2.26MB

// pjson解析
$json = new Json();
$json_val = $json->parse($json_str);
$json_obj = $json->valToObj($json_val);

// 拿其中一个字段
$type = $json->objGetVal($json_obj, "type"); // 占用内存：533.66KB

// // 占用内存
// $current_memory = memory_get_usage();
// echo "当前内存占用: " . formatBytes($current_memory);


$end = microtime(true); // 记录结束时间
$time = $end - $start;  // 计算总耗时（单位：秒）
echo "执行耗时: " . round($time, 4) . " 秒";