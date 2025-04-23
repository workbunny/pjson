<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';


/**
 * 分批生成并追加JSON数据到文件
 *
 * @param string $filename 文件名
 * @param int $totalItems 总数据量
 * @param int $batchSize 每批数据量
 */
function generateLargeJsonFile($filename, $totalItems, $batchSize = 1000)
{
    // 打开文件，如果文件不存在则创建
    $file = fopen($filename, 'w');
    if (!$file) {
        die("无法打开文件: $filename");
    }

    // 写入JSON数组的开头
    fwrite($file, "[\n");

    // 分批生成数据
    for ($i = 0; $i < $totalItems; $i += $batchSize) {
        $batch = [];
        for ($j = 0; $j < $batchSize && $i + $j < $totalItems; $j++) {
            $batch[] = [
                'id' => $i + $j,
                'name' => 'User_' . ($i + $j),
                'age' => rand(18, 60)
            ];
        }

        // 将批次数据转换为JSON字符串
        $jsonBatch = json_encode($batch, JSON_PRETTY_PRINT);

        // 去掉批次数据的开头和结尾的方括号
        $jsonBatch = substr($jsonBatch, 1, -1);

        // 如果不是第一批数据，在前面加逗号
        if ($i > 0) {
            fwrite($file, ",\n");
        }

        // 写入批次数据
        fwrite($file, $jsonBatch);
    }

    // 写入JSON数组的结尾
    fwrite($file, "\n]");

    // 关闭文件
    fclose($file);

    echo "JSON文件生成完成: $filename\n";
}

// 示例：生成一个包含100000条数据的JSON文件，每批1000条
generateLargeJsonFile('large_data.json', $argv[1] ?? 100000, 1000);

