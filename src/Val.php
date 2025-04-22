<?php

// 严格模式
declare(strict_types=1);

namespace Workbunny\PJson;

/**
 * json值对象操作类
 */
class Val extends Base
{
    /**
     * 获取json_val转json_obj对象
     *
     * @param \FFI\CData $json_val json_val对象
     * @return \FFI\CData json_obj对象
     * @throws \Exception 失败时抛出异常
     */
    public static function getObj(\FFI\CData $json_val): \FFI\CData
    {
        $json_obj = self::ffi()->json_value_get_object($json_val);
        if ($json_obj === null) {
            throw new \Exception("Failed to obtain the json_obj object");
        }
        return $json_obj;
    }

    /**
     * 获取json_val转json_arr对象
     *
     * @param \FFI\CData $json_val json_val对象
     * @return \FFI\CData json_arr对象
     * @throws \Exception 失败时抛出异常
     */
    public static function getArr(\FFI\CData $json_val): \FFI\CData
    {
        $json_arr = self::ffi()->json_value_get_array($json_val);
        if ($json_arr === null) {
            throw new \Exception("This json value is not a json array.");
        }
        return $json_arr;
    }

    /**
     * 获取json_val转字符串
     *
     * @param \FFI\CData $json_val json_val对象
     * @return string 字符串
     */
    public static function getStr(\FFI\CData $json_val): string
    {
        $str = self::ffi()->json_value_get_string($json_val);
        if ($str === null) {
            throw new \Exception("This json value is not a string.");
        }
        return $str;
    }

    /**
     * 获取json_val转数字
     *
     * @param \FFI\CData $json_val json_val对象
     * @return integer|float 数字 失败时返回 0
     */
    public static function getNum(\FFI\CData $json_val): int|float
    {
        if (Json::type($json_val) !== "json_num") {
            throw new \Exception("This json value is not a number.");
        }
        return self::ffi()->json_value_get_number($json_val);
    }

    /**
     * json_val转布尔值
     *
     * @param \FFI\CData $json_val json_val对象
     * @return boolean 布尔值
     * @throws \Exception 失败时抛出异常
     */
    public static function getBool(\FFI\CData $json_val): bool
    {
        $bool = self::ffi()->json_value_get_boolean($json_val);
        if ($bool === -1) {
            throw new \Exception("Failed to get the boolean value.");
        }
        return $bool ? true : false;
    }

    /**
     * 获取json_val的父级对象
     *
     * @param \FFI\CData $json_val json_val对象
     * @return \FFI\CData 父级json_val对象
     * @throws \Exception 失败时抛出异常
     */
    public static function getParent(\FFI\CData $json_val): \FFI\CData
    {
        $parent = self::ffi()->json_value_get_parent($json_val);
        if ($parent === null) {
            throw new \Exception("Failed to obtain the parent of the json_val object");
        }
        return $parent;
    }
}
