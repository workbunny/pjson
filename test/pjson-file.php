<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('memory_limit', '-1');

function benchmark(string $label, callable $func)
{
    $startTime   = microtime(true);
    $memoryStart = memory_get_usage();
    $result = $func();
    $memoryEnd = memory_get_usage();
    $endTime   = microtime(true);

    $totalTime      = $endTime - $startTime;
    $memoryDiff     = $memoryEnd - $memoryStart;

    echo "【{$label}】\n";
    printf("总耗时：%.8f 秒\n", $totalTime);
    echo "内存变化：{$memoryDiff} 字节\n";
    echo str_repeat('-', 40) . "\n";
}

$pjson = new Workbunny\PJson\Pjson();
$object = null;

echo "\n=== PJson-file 性能对比 ===\n";
benchmark('PJson file decode', function () use ($pjson, &$object) {
    $object = $pjson->decode(__DIR__ . '/../large_data.json', true);
});

benchmark('PJson file get', function () use ($pjson, &$object) {
    dump($object[1]['name']);
});

benchmark('PJson file set', function () use ($pjson, &$object) {
    $object[1]['name'] = '修改了名字-pjson';
    dump($object[1]['name']);
});

echo "\n=== PHP JSON-file 性能对比 ===\n";
$object = null;
benchmark('PHP file decode', function () use (&$object) {
    $jsonString = file_get_contents(__DIR__ . '/../large_data.json');
    $object = json_decode($jsonString, true);
});

benchmark('PHP file get', function () use (&$object) {
    dump($object[1]['name']);
});

benchmark('PHP file set', function () use (&$object) {
    $object[1]['name'] = '修改了名字-php';
    dump($object[1]['name']);
});