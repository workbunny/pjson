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

$num = '18';

$val = '{"name":"workbunny","age":18,"sex":"男","hobby":["编程","学习","运动"],"address":{"city":"北京","street":"朝阳区"}}';

// json文件内容
// $json_str = file_get_contents("https://geo.datav.aliyun.com/areas_v3/bound/100000.json");

$start = microtime(true);

// pjson解析
$json_val = Json::parse_str($val);
$json_arr = Json::getArr($json_val, "hobby");
var_dump(Json::serialize($json_arr));


// 占用内存
$current_memory = memory_get_usage();
echo "当前内存占用: " . formatBytes($current_memory) . "\n";


$end = microtime(true); // 记录结束时间
$time = $end - $start;  // 计算总耗时（单位：秒）
echo "执行耗时: " . round($time, 4) . " 秒";
