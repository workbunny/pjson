## Json 解析操作类

```php
/**
 * 解析json字符串
 *
 * @param string $json json字符串
 * @return \FFI\CData json_val对象
 */
public static function parse_str(string $json): \FFI\CData
{}

/**
 * 解析json文件
 *
 * @param string $file json文件路径
 * @return \FFI\CData json_val对象
 */
public static function parse_file(string $file): \FFI\CData
{}

/**
 * 获取json中的字符串
 *
 * @param \FFI\CData $json_val json_val对象
 * @param string $key 键名 支持多级键名，用.分隔
 * @param string $grade_symbol 多级键名分隔符 默认. 如：a.b.c 表示 a 下的 b 下的 c
 * @return string 字符串
 */
public static function getStr(
    \FFI\CData $json_val,
    string $key,
    string $grade_symbol = "."
): string {}

/**
 * 获取json中的数字
 *
 * @param \FFI\CData $json_val json_val对象
 * @param string $key 键名 支持多级键名，用.分隔
 * @param string $grade_symbol 多级键名分隔符 默认. 如：a.b.c 表示 a 下的 b 下的 c
 * @return integer|float 数字
 */
public static function getNum(
    \FFI\CData $json_val,
    string $key,
    string $grade_symbol = "."
): int|float {}

/**
 * 获取json中的布尔值
 * 支持多级键名，用.分隔
 * 如：a.b.c 表示 a 下的 b 下的 c
 *
 * @param \FFI\CData $json_val json_val对象
 * @param string $key 键名 支持多级键名，用.分隔
 * @param string $grade_symbol 多级键名分隔符 默认. 如：a.b.c 表示 a 下的 b 下的 c
 * @return boolean 布尔值
 */
public static function getBool(
    \FFI\CData $json_val,
    string $key,
    string $grade_symbol = "."
): bool {}

/**
 * 获取json中的json数组对象
 * 支持多级键名，用.分隔
 * 如：a.b.c 表示 a 下的 b 下的 c
 *
 * @param \FFI\CData $json_val json_val对象
 * @param string $key 键名 支持多级键名，用.分隔
 * @param string $grade_symbol 多级键名分隔符 默认. 如：a.b.c 表示 a 下的 b 下的 c
 * @return \FFI\CData json_arr对象
 */
public static function getArr(
    \FFI\CData $json_val,
    string $key,
    string $grade_symbol = "."
): \FFI\CData {}

/**
 * 获取json中的json_Obj对象
 * 支持多级键名，用.分隔
 * 如：a.b.c 表示 a 下的 b 下的 c
 *
 * @param \FFI\CData $json_val json_val对象
 * @param string $key 键名 支持多级键名，用.分隔
 * @param string $grade_symbol 多级键名分隔符 默认. 如：a.b.c 表示 a 下的 b 下的 c
 * @return \FFI\CData json_obj对象
 */
public static function getObj(\FFI\CData $json_val, string $key, string $grade_symbol = "."): \FFI\CData
{}

/**
 * 获取json_val中的json_val值
 * 支持多级键名，用.分隔
 * 如：a.b.c 表示 a 下的 b 下的 c
 *
 * @param \FFI\CData $json_val json_val对象
 * @param string $key 键名 支持多级键名，用.分隔 如：a.b.c 表示 a 下的 b 下的 c
 * @param string $grade_symbol 多级键名分隔符 默认. 
 * @return \FFI\CData
 */
public static function getVal(\FFI\CData $json_val, string $key, string $grade_symbol = "."): \FFI\CData
{}

/**
 * 获取json_val类型
 *
 * @param \FFI\CData $json_val
 * @return string 类型 json_null json_bool json_number json_string json_array json_object
 */
public static function type(\FFI\CData $json_val): string
{}

/**
 * 序列化json对象为字符串
 *
 * @param \FFI\CData $json_val json_val对象
 * @return string 字符串
 */
public static function serialize(\FFI\CData $json_val): string
{}

/**
 * json_val对象转php数组(如果数据过大会占用内存)
 *
 * @param \FFI\CData $json_val json_val对象
 * @return mixed php数组
 */
public static function toArray(\FFI\CData $json_val): mixed
{}
```
