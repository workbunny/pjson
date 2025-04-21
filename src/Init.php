<?php

// 严格模式
declare(strict_types=1);

namespace Workbunny\PJson;

/**
 * 初始化类型
 */
class Init extends Base
{
    /**
     * 初始化json_obj对象
     *
     * @return \FFI\CData json_val对象
     */
    public static function obj(): \FFI\CData
    {
        $json_val = self::ffi()->json_value_init_object();
        if ($json_val == null) {
            throw new \Exception("The initialization of the json object failed.");
        }
        return $json_val;
    }

    /**
     * 初始化json_arr对象
     *
     * @return \FFI\CData json_val对象
     */
    public static function arr(): \FFI\CData
    {
        $json_val = self::ffi()->json_value_init_array();
        if ($json_val == null) {
            throw new \Exception("The initialization of the json array failed.");
        }
        return $json_val;
    }

    /**
     * 初始化json_str对象
     *
     * @param string $str 字符串
     * @return \FFI\CData json_val对象
     */
    public static function str(string $str): \FFI\CData
    {
        $json_val = self::ffi()->json_value_init_string($str);
        if ($json_val == null) {
            throw new \Exception("The initialization of the json string failed.");
        }
        return $json_val;
    }

    /**
     * 初始化json_num对象
     *
     * @param float $num 数字
     * @return \FFI\CData json_val对象
     */
    public static function num(float $num): \FFI\CData
    {
        $json_val = self::ffi()->json_value_init_number($num);
        if ($json_val == null) {
            throw new \Exception("The initialization of the json number failed.");
        }
        return $json_val;
    }

    /**
     * 初始化json_bool对象
     *
     * @param bool $bool 布尔值
     * @return \FFI\CData json_val对象
     */
    public static function bool(bool $bool): \FFI\CData
    {
        $json_val = self::ffi()->json_value_init_boolean($bool);
        if ($json_val == null) {
            throw new \Exception("The initialization of the json boolean failed.");
        }
        return $json_val;
    }

    /**
     * 初始化json_null对象
     *
     * @return \FFI\CData json_val对象
     */
    public static function null(): \FFI\CData
    {
        $json_val = self::ffi()->json_value_init_null();
        if ($json_val == null) {
            throw new \Exception("The initialization of the json null failed.");
        }
        return $json_val;
    }

    /**
     * 复制json_val对象
     *
     * @param \FFI\CData $json_val json_val对象
     * @return \FFI\CData json_val对象
     */
    public static function copy(\FFI\CData $json_val): \FFI\CData
    {
        $json_val = self::ffi()->json_value_deep_copy($json_val);
        if ($json_val == null) {
            throw new \Exception("The copy of the json value failed.");
        }
        return $json_val;
    }

    /**
     * 释放json_val对象
     *
     * @param \FFI\CData $json_val json_val对象
     * @return void
     */
    public static function free(\FFI\CData $json_val): void
    {
        self::ffi()->json_value_free($json_val);
    }
}
