<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$pjson = new Workbunny\PJson\Pjson();

// 解析
$jsonString = '{/*ww*/"name":"workbunny","isBool":false,"age":18,"sex":"男","hobby":["编程",60,"运动"],"address":{"city":"北京","street":"朝阳区"}}';
$object = $pjson->decode($jsonString, true);
foreach ($object as $key => $value) {
    dump($key, $value);
}
// get
dump(
    $object['name'],
    $object['address']['city'],
    $object['hobby'][0],
);
// set
$object['name'] = 'workbunny-1';
$object['address']['city'] = '上海';
$object['hobby'][1] = '66';
dump($object->serialize());


$object = $pjson->decode(__DIR__ . '/../large_data.json', true);

dump($object[1]);
// 序列化
dump(
    // string
    $pjson->encode('aaa'),
    // bool
    $pjson->encode(true),
    // number
    $pjson->encode(123),
    // null
    $pjson->encode(null),
    // array
    $pjson->encode([
        'name' => 'workbunny',
        'isBool' => false,
        'address' => [
            'city' => '北京',
            'street' => '朝阳区'
        ],
        'hobby' => [
            '编程',
            60,
            '运动'
        ]
    ]),
);
