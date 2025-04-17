## Json 对象

```php
/**
 *  解析json字符串
 *
 * @param string $json json字符串
 * @return \FFI\CData json_val json对象或者json数组
 * @throws \Exception 解析失败
 */
public static function decode(string $json): \FFI\CData
{}

/**
 * 序列化json对象或者json数组为字符串
 *
 * @param \FFI\CData $json_val json对象或者json数组
 * @return string json字符串
 */
public static function encode(\FFI\CData $json_val): string
{}

/**
 * 获取json_val的类型
 *
 * @param \FFI\CData $json_val json对象或者json数组
 * @return string object|array 类型
 * @throws \Exception 不是json对象或者json数组
 */
public static function jsonType(\FFI\CData $json_val): string
{}

```
