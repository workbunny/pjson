#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Workbunny\PJson\PJson;

ini_set('memory_limit', -1);
/**
 * 递归遍历解码后的数据，确保所有节点都被访问
 *
 * @param mixed $data
 */
function iterateDecodedData($data)
{
    if (is_array($data) or is_iterable($data)) {
        foreach ($data as $v) {
            iterateDecodedData($v);
        }
    } elseif (is_object($data)) {
        foreach (get_object_vars($data) as $v) {
            iterateDecodedData($v);
        }
    }
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
        if (is_array($result) || is_object($result)) {
            iterateDecodedData($result);
        }
    }
    $memoryEnd = memory_get_usage();
    $endTime   = microtime(true);

    $totalTime      = $endTime - $startTime;
    $avgTimePerCall = $totalTime / $iterations;
    $memoryDiff     = $memoryEnd - $memoryStart;

    echo "【{$label}】 (迭代：{$iterations} 次)\n";
    printf("总耗时：%.8f 秒\n", $totalTime);
    printf("每次平均耗时：%.8f 秒\n", $avgTimePerCall);
    echo "内存变化：{$memoryDiff} 字节\n";
    echo str_repeat('-', 40) . "\n";
}

// 构造一个较复杂的数据结构用于 encode/decode 测试
$memoryStart = memory_get_usage();
$data = [];
for ($i = 0; $i < 100000; $i++) {
    $data[] = [
        "id"      => $i,
        "name"    => "测试{$i}",
        "value"   => mt_rand(1, 1000),
        "tags"    => ["tag1", "tag2", "tag3"],
        "nested"  => [
            "sub_id"      => $i,
            "description" => str_repeat("数据 ", 10),
        ]
    ];
}
echo "=== 数据结构大小：" . (memory_get_usage() - $memoryStart) . " 字节 ===\n";
// 使用 PHP 内置 json_encode 构造 JSON 字符串样本
$jsonString = json_encode($data);
// 初始化 pjson 实例
$pjson = new Pjson();
$iterations = $argv[1] ?: 100;
echo "=== JSON Decode ===\n";

// 测试 PHP 原生 json_decode
benchmark("PHP json_decode", function () use ($jsonString) {
    // 第二个参数传true返回数组，也可测试返回对象
    return json_decode($jsonString, true);
}, $iterations);

// 测试 pjson 的 decode
benchmark("PJson decode", function () use ($jsonString, $pjson) {
    return $pjson->decode($jsonString);
}, $iterations);

echo "\n=== JSON Encode 性能对比 ===\n";

// 测试 PHP 原生 json_encode
benchmark("PHP json_encode", function () use ($data) {
    return json_encode($data);
}, $iterations);

// 测试 pjson 的 encode
benchmark("PJson encode", function () use ($data, $pjson) {
    return $pjson->encode($data);
}, $iterations);
