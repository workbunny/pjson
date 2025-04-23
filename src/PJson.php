<?php

declare(strict_types=1);

namespace Workbunny\PJson;

use FFI;
use FFI\CData;
use JsonException;

/**
 * @method static CData json_parse_string(string $json) 解析json字符串
 *
 * @method static int json_value_get_type(CData $jsonValue) 获取json_value类型
 * @method static string json_value_get_string(CData $jsonValue) 获取json_value字符串
 * @method static int json_value_get_number(CData $jsonValue) 获取json_value数字
 * @method static bool json_value_get_boolean(CData $jsonValue) 获取json_value布尔值
 * @method static CData json_value_get_object(CData $jsonValue) 获取json_value对象
 * @method static CData json_value_get_array(CData $jsonValue) 获取json_value数组
 *
 * @method static CData json_object_get_value(CData $jsonObject, mixed $key) 获取json_object对象中的值
 * @method static int json_object_has_value(CData $jsonObject, mixed $key) 判断json_object对象中是否存在key
 * @method static int json_object_remove(CData $jsonObject, mixed $key) 删除json_object对象中的值
 * @method static int json_object_set_value(CData $jsonObject, mixed $key, CData $jsonValue) 添加json_object对象中的值
 *
 * @method static CData json_array_get_value(CData $jsonArray, int $index) 获取json_array对象中的值
 * @method static int json_array_remove(CData $jsonArray, int $index) 删除json_array对象中的值
 * @method static int json_array_append_value(CData $jsonArray, CData $jsonValue) 添加json_array对象中的值
 *
 * @method static CData json_value_init_object() 初始化json_value对象
 * @method static CData json_value_init_array() 初始化json_value数组
 * @method static CData json_value_init_string(string $str) 初始化json_value字符串
 * @method static CData json_value_init_number(float $num) 初始化json_value数字
 * @method static CData json_value_init_boolean(bool $bool) 初始化json_value布尔值
 * @method static CData json_value_init_null() 初始化json_value空值
 *
 * @method static string json_serialize_to_string_pretty(CData $jsonValue) 格式化输出json_value对象
 * @method static string json_serialize_to_string(CData $jsonValue) 输出json_value对象
 *
 */
class PJson
{
    /** @var FFI|null  */
    protected static ?FFI $ffi = null;

    /** @var string|null  */
    protected static ?string $libPath = null;

    /** @var string|null  */
    protected static ?string $headerPath = null;

    /**
     * @param string|null $libPath
     * @param string $headerPath
     * @return FFI|null
     */
    public static function ffi(string $libPath = null, string $headerPath = __DIR__ . '/PJson.h'): ?FFI
    {
        if (!extension_loaded('ffi')) {
            throw new \RuntimeException('FFI extension is not loaded.');
        }
        if (
            !static::$ffi or
            ($libPath and $libPath !== static::$libPath) or
            ($headerPath and $headerPath !== static::$headerPath)
        ) {
            static::$libPath = static::$ffi ?? (
            (DIRECTORY_SEPARATOR === '\\')
                ? dirname(__DIR__) . '/lib/PJson.dll'
                : dirname(__DIR__) . '/lib/PJson.so'
            );
            static::$ffi = FFI::cdef(file_get_contents(static::$headerPath = $headerPath), static::$libPath);
        }
        return static::$ffi;
    }


    public function __construct()
    {
        static::ffi();
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return call_user_func_array([static::ffi(), $name], $arguments);
    }

    /**
     * 解析json字符串
     *
     * @param string $json
     * @return Types
     * @throws JsonException
     */
    public function decode(string $json): Types
    {
        if (!$jsonValue = Pjson::json_parse_string($json)) {
            throw new JsonException('json string format error.', 0);
        }
        return new Types($jsonValue);
    }

    /**
     * 编码json数据
     *
     * @param mixed $data
     * @param bool $pretty
     * @return string
     */
    public function encode(mixed $data, bool $pretty = false): string
    {
        return (new Types($data))->serialize($pretty);
    }

}
