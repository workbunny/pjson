## Arr对象

处理json数组相关操作。

```php

/**
 * 获取json数组中的字符串
 *
 * @param \FFI\CData $json_arr json数组
 * @param int $index 索引
 * @return string 字符串
 */
public static function getStr(\FFI\CData $json_arr, int $index): string
{}

/**
 * 获取json数组中的json对象
 *
 * @param \FFI\CData $json_arr json数组
 * @param integer $index 索引
 * @return \FFI\CData json对象
 */
public static function getObj(\FFI\CData $json_arr, int $index): \FFI\CData
{}

/**
 * 获取json数组中的json数组
 *
 * @param \FFI\CData $json_arr json数组
 * @param integer $index 索引
 * @return \FFI\CData json数组
 */
public static function getArr(\FFI\CData $json_arr, int $index): \FFI\CData
{}

/**
 * 获取json数组中的布尔值
 *
 * @param \FFI\CData $json_arr json数组
 * @param integer $index 索引
 * @return boolean 布尔值
 */
public static function getBool(\FFI\CData $json_arr, int $index): bool
{}

/**
 * 获取json数组中的数字,失败时返回 0
 *
 * @param \FFI\CData $json_arr json数组
 * @param integer $index 索引
 * @return float 数字
 */
public static function getNum(\FFI\CData $json_arr, int $index): float
{}

/**
 * 获取json数组中元素的数量
 *
 * @param \FFI\CData $json_arr json数组
 * @return integer 元素的数量 
 * 
 */
public static function getCount(\FFI\CData $json_arr): int
{}

/**
 * 移除json数组中的元素
 *
 * @param \FFI\CData $json_arr json数组
 * @param integer $index 索引
 * @return void
 */
public static function remove(\FFI\CData $json_arr, int $index): void
{}

/**
 * 设置json数组中新的json对象
 *
 * @param \FFI\CData $json_arr json数组
 * @param integer $index 索引
 * @param \FFI\CData $json_obj json对象
 * @return void
 */
public static function setObj(\FFI\CData $json_arr, int $index, \FFI\CData $json_obj): void
{}

/**
 * 设置json数组中新的json数组
 *
 * @param \FFI\CData $json_arr json数组
 * @param integer $index 索引
 * @param \FFI\CData $json_arr2 json数组
 * @return void
 */
public static function setArr(\FFI\CData $json_arr, int $index, \FFI\CData $json_arr2): void
{}

/**
 * 设置json数组中新的字符串
 *
 * @param \FFI\CData $json_arr json数组
 * @param integer $index 索引
 * @param string $str 字符串
 * @return void
 */
public static function setStr(\FFI\CData $json_arr, int $index, string $str): void
{}

/**
 * 设置json数组中新的数字
 *
 * @param \FFI\CData $json_arr json数组
 * @param integer $index 索引
 * @param float $num 数字
 * @return void
 */
public static function setNum(\FFI\CData $json_arr, int $index, float $num): void
{}

/**
 * 设置json数组中新的布尔值
 *
 * @param \FFI\CData $json_arr json数组
 * @param integer $index 索引
 * @param boolean $bool 布尔值
 * @return void
 */
public static function setBool(\FFI\CData $json_arr, int $index, bool $bool): void
{}

/**
 * 向json数组中添加新的null
 *
 * @param \FFI\CData $json_arr json数组
 * @param integer $index 索引
 * @return void
 */
public static function setNull(\FFI\CData $json_arr, int $index): void
{}

/**
 * 移除数组中的所有值
 *
 * @param \FFI\CData $json_arr json数组
 * @return void
 */
public static function clear(\FFI\CData $json_arr): void
{}

/**
 * 向json数组末尾中添加新的json对象
 *
 * @param \FFI\CData $json_arr json数组
 * @param \FFI\CData $json_obj json对象
 * @return void
 */
public static function appendObj(\FFI\CData $json_arr, \FFI\CData $json_obj): void
{}

/**
 * 向json数组末尾中添加新的json数组
 *
 * @param \FFI\CData $json_arr json数组
 * @param \FFI\CData $json_arr2 json数组
 * @return void
 */
public static function appendArr(\FFI\CData $json_arr, \FFI\CData $json_arr2): void
{}

/**
 * 向json数组末尾中添加新的字符串
 *
 * @param \FFI\CData $json_arr json数组
 * @param string $str 字符串
 * @return void
 */
public static function appendStr(\FFI\CData $json_arr, string $str): void
{}

/**
 * 向json数组末尾中添加新的数字
 *
 * @param \FFI\CData $json_arr json数组
 * @param float $num 数字
 * @return void
 */
public static function appendNum(\FFI\CData $json_arr, float $num): void
{}

/**
 * 向json数组末尾中添加新的布尔值
 *
 * @param \FFI\CData $json_arr json数组
 * @param boolean $bool 布尔值
 * @return void
 */
public static function appendBool(\FFI\CData $json_arr, bool $bool): void
{}

/**
 * 向json数组末尾中添加新的null
 *
 * @param \FFI\CData $json_arr json数组
 * @return void
 */
public static function appendNull(\FFI\CData $json_arr): void
{}
```