<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Workbunny\PJson\Json;

ini_set('memory_limit', -1);

/**
 * 格式化字节数为人类可读的格式
 *
 * @param int $bytes
 * @return string
 */
function formatBytes($bytes): string
{
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = 0;
    while ($bytes >= 1024 && $i < 3) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . $units[$i];
}

/**
 * 执行多次调用并统计总耗时、平均时间及内存变化
 *
 * @param string   $label        测试项名称
 * @param callable $func         测试闭包（内部完成 encode 或 decode 操作）
 * @param int      $iterations   迭代次数
 */
function benchmark(string $label, callable $func, int $iterations = 1)
{
    $startTime   = microtime(true);
    $memoryStart = memory_get_usage();

    for ($i = 0; $i < $iterations; $i++) {
        $result = $func();
    }
    $memoryEnd = memory_get_usage();
    $endTime   = microtime(true);

    $totalTime      = $endTime - $startTime;
    $avgTimePerCall = $totalTime / $iterations;
    $memoryDiff     = $memoryEnd - $memoryStart;

    echo "【{$label}】 (迭代：{$iterations} 次)\n";
    printf("总耗时：%.8f 秒\n", $totalTime);
    printf("每次平均耗时：%.8f 秒\n", $avgTimePerCall);
    echo "内存变化：" . formatBytes($memoryDiff) . "\n";
    echo str_repeat('-', 40) . "\n";
}

$json = file_get_contents("https://geo.datav.aliyun.com/areas_v3/bound/100000.json");

// 原生PHP JSON
benchmark("原生PHP JSON", function () use ($json) {
    $root = json_decode($json, true);
    echo "features.0.properties.name：" . $root["features"][0]["properties"]["name"] . "\n";
    echo "当前内存：" . formatBytes(memory_get_usage()) . "\n";
});

// PJson JSON
benchmark("PJson JSON", function () use ($json) {
    $root = Json::parse($json);
    $name = Json::deepGet($root, '/features/0/properties/name');
    echo "features.0.properties.name：" . Json::val($name)  . "\n";
    echo "当前内存：" . formatBytes(memory_get_usage()) . "\n";
});
