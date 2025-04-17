## json对象

处理json对象相关操作

```php
/**
    * 初始化一个 JSON 对象值
    *
    * @return \FFI\CData
    */
public static function init(): \FFI\CData
{}

/**
    * 获取json对象的字符串值
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return string 字符串值
    */
public static function getStr(\FFI\CData $json_obj, string $key): string
{}

/**
    * 获取json对象中的json对象
    *
    * @param \FFI\CData $json_obj
    * @param string $key
    * @return \FFI\CData
    */
public static function getObj(\FFI\CData $json_obj, string $key): \FFI\CData
{}

/**
    * 获取json对象的json数组对象
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return \FFI\CData json数组对象
    */
public static function getArr(\FFI\CData $json_obj, string $key): \FFI\CData
{}

/**
    * 获取json对象的布尔值
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return boolean 布尔值
    */
public static function getBool(\FFI\CData $json_obj, string $key): bool
{}

/**
    * 获取json对象的数字值, 失败时返回 0
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return float 数字值
    */
public static function getNum(\FFI\CData $json_obj, string $key): float
{}

/**
    * 获取json对象的字符串值。
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return string 字符串值
    */
public static function DotgetStr(\FFI\CData $json_obj, string $key): string
{}

/**
    * 获取json对象中的json对象。
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return \FFI\CData json对象
    */
public static function DotgetObj(\FFI\CData $json_obj, string $key): \FFI\CData
{}

/**
    * 获取json对象的json数组对象。
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return \FFI\CData json数组对象
    */
public static function DotgetArr(\FFI\CData $json_obj, string $key): \FFI\CData
{}

/**
    * 获取json对象的布尔值。
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return boolean 布尔值
    */
public static function DotgetBool(\FFI\CData $json_obj, string $key): bool
{}

/**
    * 获取json对象的数字值, 失败时返回 0。
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return float 数字值
    */
public static function DotgetNum(\FFI\CData $json_obj, string $key): float
{}

/**
    * 获取对象中键值对的数量
    * 
    * @param \FFI\CData $json_obj json对象
    * @return integer 键值对的数量
    */
public static function getCount(\FFI\CData $json_obj): int
{}

/**
    * 获取对象中指定索引处的键名
    *
    * @param \FFI\CData $json_obj json对象
    * @param integer $index 索引
    * @return string 键名
    */
public static function getKey(\FFI\CData $json_obj, int $index): string
{}

/**
    * 检查json对象中的键是否存在
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return boolean true 存在 false 不存在
    */
public static function has(\FFI\CData $json_obj, string $key): bool
{}

/**
    * 检查json对象中的键是否存在
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return boolean true 存在 false 不存在
    */
public static function DotHas(\FFI\CData $json_obj, string $key): bool
{}

/**
    * 检查json对象中的键是否存在
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @param Type $type 类型
    * @return boolean true 存在 false 不存在
    */
public static function hasType(\FFI\CData $json_obj, string $key, Type $type): bool
{}

/**
    * 检查json对象中的键是否存在
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @param Type $type 类型
    * @return boolean true 存在 false 不存在
    */
public static function DotHasType(\FFI\CData $json_obj, string $key, Type $type): bool
{}

/**
    * 设置json对象中的键值对内容为新的json对象
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @param \FFI\CData $son_json_obj json对象
    * @return void
    */
public static function setObj(\FFI\CData $json_obj, string $key, \FFI\CData $son_json_obj): void
{}

/**
    * 设置json对象中的键值对内容为新的json字符串
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @param string $value 字符串
    * @return void
    */
public static function setStr(\FFI\CData $json_obj, string $key, string $value): void
{}

/**
    * 设置json对象中的键值对内容为新的json数组对象
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @param \FFI\CData $son_json_arr json数组对象
    * @return void
    */
public static function setArr(\FFI\CData $json_obj, string $key, \FFI\CData $son_json_arr): void
{}

/**
    * 设置json对象中的键值对内容为新的json数字
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @param float $num 数字
    * @return void
    */
public static function setNum(\FFI\CData $json_obj, string $key, float $num): void
{}

/**
    * 设置json对象中的键值对内容为新的json布尔值
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @param boolean $bool 布尔值
    * @return void
    */
public static function setBool(\FFI\CData $json_obj, string $key, bool $bool): void
{}

/**
    * 设置json对象中的键值对内容为新的json null
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return void
    */
public static function setNull(\FFI\CData $json_obj, string $key): void
{}

/**
    * 设置json对象中的键值对内容为新的json对象
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @param \FFI\CData $son_json_obj json对象
    * @return void
    */
public static function DotSetObj(\FFI\CData $json_obj, string $key, \FFI\CData $son_json_obj): void
{}

/**
    * 设置json对象中的键值对内容为新的json字符串
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @param string $value 字符串
    * @return void
    */
public static function DotSetStr(\FFI\CData $json_obj, string $key, string $value): void
{}

/**
    * 设置json对象中的键值对内容为新的json数组对象
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @param \FFI\CData $son_json_arr json数组对象
    * @return void
    */
public static function DotSetArr(\FFI\CData $json_obj, string $key, \FFI\CData $son_json_arr): void
{}

/**
    * 设置json对象中的键值对内容为新的json数字
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @param float $num 数字
    * @return void
    */
public static function DotSetNum(\FFI\CData $json_obj, string $key, float $num): void
{}

/**
    * 设置json对象中的键值对内容为新的json布尔值
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @param boolean $bool 布尔值
    * @return void
    */
public static function DotSetBool(\FFI\CData $json_obj, string $key, bool $bool): void
{}

/**
    * 设置json对象中的键值对内容为新的json null
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *  
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return void
    */
public static function DotSetNull(\FFI\CData $json_obj, string $key): void
{}

/**
    * 移除指定名称的键值对
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return void
    */
public static function remove(\FFI\CData $json_obj, string $key): void
{}

/**
    * 移除指定名称的键值对
    * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
    * 例如(objectA.objectB.value)。
    * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
    *
    * @param \FFI\CData $json_obj json对象
    * @param string $key 键名
    * @return void
    */
public static function dotRemove(\FFI\CData $json_obj, string $key): void
{}

/**
    * 移除对象中的所有键值对
    *
    * @param \FFI\CData $json_obj json对象
    * @return void
    */
public static function clear(\FFI\CData $json_obj): void
{}
```
