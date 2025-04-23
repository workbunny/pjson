# pjson
✨ PJson 用于解析 JSON 数据并提供高效的内存管理优化。

## 依赖

- `PHP` >= 8.1
- `ext-FFI` *

## 安装

```bash
# 暂未开启
composer require workbunny/pjson
```

## 使用

### decode

```php
$pjson = new Workbunny\PJson\Pjson();

// 解析 jsonString
$jsonString = '{/*ww*/"name":"workbunny","isBool":false,"age":18,"sex":"男","hobby":["编程",60,"运动"],"address":{"city":"北京","street":"朝阳区"}}';
$object = $pjson->decode($jsonString, true);

// 解析 jsonFile
$file = $pjson->decode(__DIR__.'/json.json', true);

// 支持遍历
foreach ($object as $key => $value) {
    var_dump($key, $value);
}
// count
var_dump(count($object));
// get
var_dump(
    $object['name'],
    $object['address']['city'],
    $object['hobby'][1],
);
// set
$object['name'] = 'workbunny-1';
$object['address']['city'] = '上海';
$object['hobby'][1] = '66';
// json encode
var_dump($object->serialize());
```
### decode

```php
$pjson = new Workbunny\PJson\Pjson();
var_dump(
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
```

### 进阶用法

#### 使用`c api`
```php
Workbunny\PJson\PJson::json_array_append_value()
Workbunny\PJson\PJson::json_array_append_string()

// .....

// PJson类实现了魔术方法，静态调用PJson.h声明的 c-api
```

#### 自定义头文件/动态库
```php
$libPath = '你的动态库文件路径';
$headerPath = '你的头文件路径';
\Workbunny\PJson\PJson::ffi($libPath, $headerPath);

// ......

// 执行逻辑
```

#### 编译动态库


```bash
./build/build.sh 
```

```cmd
./build/build.cmd
```

## 性能对比

// todo
