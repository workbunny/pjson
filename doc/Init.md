## Init 初始化设置

初始化json相关操作。

```php
/**
 * 初始化json_obj对象
 *
 * @return \FFI\CData json_val对象
 */
public static function obj(): \FFI\CData
{}

/**
 * 初始化json_arr对象
 *
 * @return \FFI\CData json_val对象
 */
public static function arr(): \FFI\CData
{}

/**
 * 初始化json_str对象
 *
 * @param string $str 字符串
 * @return \FFI\CData json_val对象
 */
public static function str(string $str): \FFI\CData
{}

/**
 * 初始化json_num对象
 *
 * @param float $num 数字
 * @return \FFI\CData json_val对象
 */
public static function num(float $num): \FFI\CData
{}

/**
 * 初始化json_bool对象
 *
 * @param bool $bool 布尔值
 * @return \FFI\CData json_val对象
 */
public static function bool(bool $bool): \FFI\CData
{}

/**
 * 初始化json_null对象
 *
 * @return \FFI\CData json_val对象
 */
public static function null(): \FFI\CData
{}

/**
 * 复制json_val对象
 *
 * @param \FFI\CData $json_val json_val对象
 * @return \FFI\CData json_val对象
 */
public static function copy(\FFI\CData $json_val): \FFI\CData
{}

/**
 * 释放json_val对象
 *
 * @param \FFI\CData $json_val json_val对象
 * @return void
 */
public static function free(\FFI\CData $json_val): void
{}
```