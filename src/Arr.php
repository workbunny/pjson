<?php

// 严格模式
declare(strict_types=1);

namespace Workbunny\PJson;

/**
 * json数组对象操作类
 */
class Arr extends Base
{
    /**
     * json数组对象转换为json_val对象
     *
     * @param \FFI\CData $json_arr json数组对象
     * @return \FFI\CData json_val对象
     */
    public static function toVal(\FFI\CData $json_arr): \FFI\CData
    {
        $arr = self::ffi()->json_array_get_wrapping_value($json_arr);
        if ($arr == null) {
            throw new \Exception('The conversion of json values to a json array failed.');
        }
        return $arr;
    }

    /**
     * 获取json数组中的字符串
     *
     * @param \FFI\CData $json_arr json数组
     * @param int $index 索引
     * @return string 字符串
     */
    public static function getStr(\FFI\CData $json_arr, int $index): string
    {
        $str = self::ffi()->json_array_get_string($json_arr, $index);
        if ($str == null) {
            throw new \Exception('The value indexed by this json array is not a string.');
        }
        return $str;
    }

    /**
     * 获取json数组中的json对象
     *
     * @param \FFI\CData $json_arr json数组
     * @param integer $index 索引
     * @return \FFI\CData json对象
     */
    public static function getObj(\FFI\CData $json_arr, int $index): \FFI\CData
    {
        $obj = self::ffi()->json_array_get_object($json_arr, $index);
        if ($obj == null) {
            throw new \Exception('The value indexed by this json array is not a json object.');
        }
        return $obj;
    }

    /**
     * 获取json数组中的json数组
     *
     * @param \FFI\CData $json_arr json数组
     * @param integer $index 索引
     * @return \FFI\CData json数组
     */
    public static function getArr(\FFI\CData $json_arr, int $index): \FFI\CData
    {
        $arr = self::ffi()->json_array_get_array($json_arr, $index);
        if ($arr == null) {
            throw new \Exception('The value indexed by this json array is not a json array.');
        }
    }

    /**
     * 获取json数组中的布尔值
     *
     * @param \FFI\CData $json_arr json数组
     * @param integer $index 索引
     * @return boolean 布尔值
     */
    public static function getBool(\FFI\CData $json_arr, int $index): bool
    {
        $bool = self::ffi()->json_array_get_boolean($json_arr, $index);
        if ($bool == -1) {
            throw new \Exception('The value indexed by this json array is not a boolean.');
        }
        return $bool ? true : false;
    }

    /**
     * 获取json数组中的数字,失败时返回 0
     *
     * @param \FFI\CData $json_arr json数组
     * @param integer $index 索引
     * @return float 数字
     */
    public static function getNum(\FFI\CData $json_arr, int $index): float
    {
        $json_val = self::ffi()->json_array_get_wrapping_value($json_arr);
        if ($json_val == null) {
            throw new \Exception('The value of the first parameter is not a json array object.');
        }
        if (Json::type($json_val) !== "json_arr") {
            throw new \Exception('The value indexed by this json array is not a number.');
        }
        return self::ffi()->json_array_get_number($json_arr, $index);
    }

    /**
     * 获取json数组中元素的数量
     *
     * @param \FFI\CData $json_arr json数组
     * @return integer 元素的数量 
     * 
     */
    public static function getCount(\FFI\CData $json_arr): int
    {
        return self::ffi()->json_array_get_count($json_arr);
    }

    /**
     * 移除json数组中的元素
     *
     * @param \FFI\CData $json_arr json数组
     * @param integer $index 索引
     * @return void
     */
    public static function remove(\FFI\CData $json_arr, int $index): void
    {
        self::ffi()->json_array_remove($json_arr, $index);
    }

    /**
     * 设置json数组中新的json对象
     *
     * @param \FFI\CData $json_arr json数组
     * @param integer $index 索引
     * @param \FFI\CData $json_obj json对象
     * @return void
     */
    public static function setObj(\FFI\CData $json_arr, int $index, \FFI\CData $json_obj): void
    {
        $json_val = self::ffi()->json_object_get_wrapping_value($json_obj);
        $res = self::ffi()->json_array_replace_value($json_arr, $index, $json_val);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json object.');
        }
    }

    /**
     * 设置json数组中新的json数组
     *
     * @param \FFI\CData $json_arr json数组
     * @param integer $index 索引
     * @param \FFI\CData $json_arr2 json数组
     * @return void
     */
    public static function setArr(\FFI\CData $json_arr, int $index, \FFI\CData $json_arr2): void
    {
        $json_val = self::ffi()->json_array_get_wrapping_value($json_arr2);
        $res = self::ffi()->json_array_replace_value($json_arr, $index, $json_val);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json array.');
        }
    }

    /**
     * 设置json数组中新的字符串
     *
     * @param \FFI\CData $json_arr json数组
     * @param integer $index 索引
     * @param string $str 字符串
     * @return void
     */
    public static function setStr(\FFI\CData $json_arr, int $index, string $str): void
    {
        $res = self::ffi()->json_array_replace_string($json_arr, $index, $str);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new string.');
        }
    }

    /**
     * 设置json数组中新的数字
     *
     * @param \FFI\CData $json_arr json数组
     * @param integer $index 索引
     * @param float $num 数字
     * @return void
     */
    public static function setNum(\FFI\CData $json_arr, int $index, float $num): void
    {
        $res = self::ffi()->json_array_replace_number($json_arr, $index, $num);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new number.');
        }
    }

    /**
     * 设置json数组中新的布尔值
     *
     * @param \FFI\CData $json_arr json数组
     * @param integer $index 索引
     * @param boolean $bool 布尔值
     * @return void
     */
    public static function setBool(\FFI\CData $json_arr, int $index, bool $bool): void
    {
        $res = self::ffi()->json_array_replace_boolean($json_arr, $index, $bool ? 1 : 0);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new boolean.');
        }
    }

    /**
     * 向json数组中添加新的null
     *
     * @param \FFI\CData $json_arr json数组
     * @param integer $index 索引
     * @return void
     */
    public static function setNull(\FFI\CData $json_arr, int $index): void
    {
        $res = self::ffi()->json_array_replace_null($json_arr, $index);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new null.');
        }
    }

    /**
     * 移除数组中的所有值
     *
     * @param \FFI\CData $json_arr json数组
     * @return void
     */
    public static function clear(\FFI\CData $json_arr): void
    {
        $res = self::ffi()->json_array_clear($json_arr);
        if ($res !== 0) {
            throw new \Exception('Failed to clear the json array.');
        }
    }

    /**
     * 向json数组末尾中添加新的json对象
     *
     * @param \FFI\CData $json_arr json数组
     * @param \FFI\CData $json_obj json对象
     * @return void
     */
    public static function appendObj(\FFI\CData $json_arr, \FFI\CData $json_obj): void
    {
        $json_val = self::ffi()->json_object_get_wrapping_value($json_obj);
        $res = self::ffi()->json_array_append_value($json_arr, $json_val);
        if ($res !== 0) {
            throw new \Exception('Failed to append the new json object.');
        }
    }

    /**
     * 向json数组末尾中添加新的json数组
     *
     * @param \FFI\CData $json_arr json数组
     * @param \FFI\CData $json_arr2 json数组
     * @return void
     */
    public static function appendArr(\FFI\CData $json_arr, \FFI\CData $json_arr2): void
    {
        $json_val = self::ffi()->json_array_get_wrapping_value($json_arr2);
        $res = self::ffi()->json_array_append_value($json_arr, $json_val);
        if ($res !== 0) {
            throw new \Exception('Failed to append the new json array.');
        }
    }

    /**
     * 向json数组末尾中添加新的字符串
     *
     * @param \FFI\CData $json_arr json数组
     * @param string $str 字符串
     * @return void
     */
    public static function appendStr(\FFI\CData $json_arr, string $str): void
    {
        $res = self::ffi()->json_array_append_string($json_arr, $str);
        if ($res !== 0) {
            throw new \Exception('Failed to append the new string.');
        }
    }

    /**
     * 向json数组末尾中添加新的数字
     *
     * @param \FFI\CData $json_arr json数组
     * @param float $num 数字
     * @return void
     */
    public static function appendNum(\FFI\CData $json_arr, float $num): void
    {
        $res = self::ffi()->json_array_append_number($json_arr, $num);
        if ($res !== 0) {
            throw new \Exception('Failed to append the new number.');
        }
    }

    /**
     * 向json数组末尾中添加新的布尔值
     *
     * @param \FFI\CData $json_arr json数组
     * @param boolean $bool 布尔值
     * @return void
     */
    public static function appendBool(\FFI\CData $json_arr, bool $bool): void
    {
        $res = self::ffi()->json_array_append_boolean($json_arr, $bool ? 1 : 0);
        if ($res !== 0) {
            throw new \Exception('Failed to append the new boolean.');
        }
    }

    /**
     * 向json数组末尾中添加新的null
     *
     * @param \FFI\CData $json_arr json数组
     * @return void
     */
    public static function appendNull(\FFI\CData $json_arr): void
    {
        $res = self::ffi()->json_array_append_null($json_arr);
        if ($res !== 0) {
            throw new \Exception('Failed to append the new null.');
        }
    }
}
