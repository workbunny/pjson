## json_val对象操作类

处理json_val对象相关操作。

```php
/**
 * 获取json_val转json_obj对象
 *
 * @param \FFI\CData $json_val json_val对象
 * @return \FFI\CData json_obj对象
 * @throws \Exception 失败时抛出异常
 */
public static function getObj(\FFI\CData $json_val): \FFI\CData
{}

/**
 * 获取json_val转json_arr对象
 *
 * @param \FFI\CData $json_val json_val对象
 * @return \FFI\CData json_arr对象
 * @throws \Exception 失败时抛出异常
 */
public static function getArr(\FFI\CData $json_val): \FFI\CData
{}

/**
 * 获取json_val转字符串
 *
 * @param \FFI\CData $json_val json_val对象
 * @return string 字符串
 */
public static function getStr(\FFI\CData $json_val): string
{}

/**
 * 获取json_val转数字
 *
 * @param \FFI\CData $json_val json_val对象
 * @return integer|float 数字 失败时返回 0
 */
public static function getNum(\FFI\CData $json_val): int|float
{}

/**
 * json_val转布尔值
 *
 * @param \FFI\CData $json_val json_val对象
 * @return boolean 布尔值
 * @throws \Exception 失败时抛出异常
 */
public static function getBool(\FFI\CData $json_val): bool
{}

/**
 * 获取json_val的父级对象
 *
 * @param \FFI\CData $json_val json_val对象
 * @return \FFI\CData 父级json_val对象
 * @throws \Exception 失败时抛出异常
 */
public static function getParent(\FFI\CData $json_val): \FFI\CData
{}
```