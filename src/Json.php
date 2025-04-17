<?php

// 严格模式
declare(strict_types=1);

namespace Workbunny\PJson;

class Json extends Base
{
    /**
     *  解析json字符串
     *
     * @param string $json json字符串
     * @return \FFI\CData json_val json对象或者json数组
     * @throws \Exception 解析失败
     */
    public static function decode(string $json): \FFI\CData
    {
        $json_val = self::ffi()->json_parse_string($json);
        if ($json_val === null) {
            throw new \Exception('json parsing failed');
        }
        $type = self::ffi()->json_type($json_val);
        if ($type === Type::obj->value) {
            return self::ffi()->json_value_get_object($json_val);
        } elseif ($type === Type::arr->value) {
            return self::ffi()->json_value_get_array($json_val);
        } else {
            throw new \Exception('It must be a regular json object format or a json array format.');
        }
    }

    /**
     * 序列化json对象或者json数组为字符串
     *
     * @param \FFI\CData $json_val json对象或者json数组
     * @return string json字符串
     */
    public static function encode(\FFI\CData $json_val): string
    {
        if ($json_val[0]->wrapping_value[0]->type === Type::obj->value) {
            $val = self::ffi()->json_object_get_wrapping_value($json_val);
            return self::ffi()->json_serialize_to_string_pretty($val);
        } else {
            $val = self::ffi()->json_array_get_wrapping_value($json_val);
            return self::ffi()->json_serialize_to_string_pretty($val);
        }
    }

    /**
     * 获取json_val的类型
     *
     * @param \FFI\CData $json_val json对象或者json数组
     * @return string object|array 类型
     * @throws \Exception 不是json对象或者json数组
     */
    public static function jsonType(\FFI\CData $json_val): string
    {
        if ($json_val[0]->wrapping_value[0]->type === Type::obj->value) {
            return 'object';
        } else if ($json_val[0]->wrapping_value[0]->type === Type::arr->value) {
            return 'array';
        } else {
            throw new \Exception('It must be a json object.');
        }
    }
}
