<?php

// 严格模式
declare(strict_types=1);

namespace Workbunny\PJson;

class Json extends Base
{
    /**
     * 解析json字符串
     *
     * @param string $json json字符串
     * @return \FFI\CData json_val对象
     */
    public static function parse_str(string $json): \FFI\CData
    {
        $json_val = self::ffi()->json_parse_string($json);
        if ($json_val == null) {
            throw new \Exception("json parsing failed.");
        }
        return $json_val;
    }

    /**
     * 解析json文件
     *
     * @param string $file json文件路径
     * @return \FFI\CData json_val对象
     */
    public static function parse_file(string $file): \FFI\CData
    {
        $json_val = self::ffi()->json_parse_file_with_comments($file);
        if ($json_val == null) {
            throw new \Exception("json parsing failed.");
        }
        return $json_val;
    }

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
    ): string {
        $explode = explode($grade_symbol, $key);
        if ($key !== "") {
            foreach ($explode as $k) {
                $json_val = self::val($json_val, $k);
            }
        }
        return Val::getStr($json_val);
    }

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
    ): int|float {
        $explode = explode($grade_symbol, $key);
        if ($key !== "") {
            foreach ($explode as $k) {
                $json_val = self::val($json_val, $k);
            }
        }
        return Val::getNum($json_val);
    }

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
    ): bool {
        $explode = explode($grade_symbol, $key);
        if ($key !== "") {
            foreach ($explode as $k) {
                $json_val = self::val($json_val, $k);
            }
        }
        return Val::getBool($json_val);
    }

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
    ): \FFI\CData {
        $explode = explode($grade_symbol, $key);
        if ($key !== "") {
            foreach ($explode as $k) {
                $json_val = self::val($json_val, $k);
            }
        }
        return Val::getArr($json_val);
    }

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
    {
        $explode = explode($grade_symbol, $key);
        if ($key !== "") {
            foreach ($explode as $k) {
                $json_val = self::val($json_val, $k);
            }
        }
        return Val::getObj($json_val);
    }

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
    {
        $explode = explode($grade_symbol, $key);
        if ($key !== "") {
            foreach ($explode as $k) {
                $json_val = self::val($json_val, $k);
            }
        }
        return $json_val;
    }

    /**
     * 获取json_val中的值
     *
     * @param \FFI\CData $json_val json_val对象
     * @param string|integer $key 键名
     * @return \FFI\CData json_val对象
     */
    private static function val(\FFI\CData $json_val, string|int $key): \FFI\CData
    {
        if ($json_val[0]->type == Type::arr->value) {
            $json_arr = self::ffi()->json_value_get_array($json_val);
            return self::ffi()->json_array_get_value($json_arr, (int)$key);
        } else if ($json_val[0]->type == Type::obj->value) {
            $json_obj = self::ffi()->json_value_get_object($json_val);
            return self::ffi()->json_object_get_value($json_obj, (string)$key);
        } else {
            return $json_val;
        }
    }

    /**
     * 获取json_val类型
     *
     * @param \FFI\CData $json_val
     * @return string
     */
    public static function type(\FFI\CData $json_val): string
    {
        return match ($json_val[0]->type) {
            Type::null->value => "json_null",
            Type::bool->value => "json_bool",
            Type::num->value => "json_num",
            Type::str->value => "json_str",
            Type::arr->value => "json_arr",
            Type::obj->value => "json_obj",
            default => throw new \Exception("Not of json type"),
        };
    }

    /**
     * 序列化json对象为字符串
     *
     * @param \FFI\CData $json_val json_val对象
     * @return string 字符串
     */
    public static function serialize(\FFI\CData $json_val): string
    {
        try {
            return self::ffi()->json_serialize_to_string_pretty($json_val);
        } catch (\FFI\Exception $e) {
            throw new \FFI\Exception("It must be a json_val object.");
        }
    }

    /**
     * json_val对象转php数组(如果数据过大会占用内存)
     *
     * @param \FFI\CData $json_val json_val对象
     * @return mixed php数组
     */
    public static function toArray(\FFI\CData $json_val): mixed
    {
        $arr = [];
        switch (self::type($json_val)) {
            case "json_null":
                $arr = null;
                break;
            case "json_bool":
                $arr = Val::getBool($json_val);
                break;
            case "json_num":
                $arr = Val::getNum($json_val);
                break;
            case "json_str":
                $arr = Val::getStr($json_val);
                break;
            case "json_arr":
                $json_arr = Val::getArr($json_val);
                $let = Arr::getCount($json_arr);
                for ($i = 0; $i < $let; $i++) {
                    $arr[] = self::toArray(Arr::getVal($json_arr, $i));
                }
                break;
            case "json_obj":
                $json_obj = Val::getObj($json_val);
                $let = Obj::getCount($json_obj);
                for ($i = 0; $i < $let; $i++) {
                    $arr[Obj::getKey($json_obj, $i)] = self::toArray(Obj::getVal($json_obj, Obj::getKey($json_obj, $i)));
                }
                break;
        }
        return $arr;
    }
}
