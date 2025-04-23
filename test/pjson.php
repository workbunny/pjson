<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';


//$jsonString = '{"name":"workbunny","isBool":false,"age":18,"sex":"男","hobby":["编程",60,"运动"],"address":{"city":"北京","street":"朝阳区"}}';
//
//$object = (new \Workbunny\PJson\PJson())->decode($jsonString);
//
//
//dump(
//    $object['name'],
//    $object['address']['city'],
//    $object['hobby'][0],
//);

dump((new \Workbunny\PJson\Types([1,2]))->serialize());
//$object = (new \Workbunny\PJson\PJson())->encode([
//    'a' => 'aaa',
//    'b' => [
//        'a' => '123'
//    ],
//    'c' => [
//        '123'
//    ]
//]);
//
//dump($object);
