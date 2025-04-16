<?php

// 严格模式
declare(strict_types=1);

namespace Workbunny\PJson;

class Json
{

    private \FFI $ffi;

    public function __construct()
    {
        $header_content = file_get_contents(__DIR__ . '/Json.h');
        $this->ffi = \FFI::cdef($header_content, $this->getLibFile());
    }

    /**
     * 获取动态库文件
     *
     * @return string 动态库文件路径
     */
    private function getLibFile(): string
    {
        $suffix = ".dll";
        // 判断系统
        switch (PHP_OS) {
            case 'Linux':
                $suffix = ".so";
                break;
            case 'Darwin':
                $suffix = ".dylib";
                break;
            default:
                break;
        }
        return dirname(__DIR__)
            . DIRECTORY_SEPARATOR . "lib"
            . DIRECTORY_SEPARATOR . "Json" . $suffix;
    }

    /**
     * 解析json字符串
     *
     * @param string $json
     * @return \FFI\CData json_val
     */
    public function parse(string $json): \FFI\CData
    {
        $json = $this->ffi->json_parse_string($json);
        if ($json === null) {
            throw new \Exception('json parsing failed');
        }
        return $json;
    }

    /**
     * 将json_val转换为json_obj
     *
     * @param \FFI\CData $json_val json_val
     * @return \FFI\CData json_obj
     */
    public function valToObj(\FFI\CData $json_val): \FFI\CData
    {
        return $this->ffi->json_value_get_object($json_val);
    }

    /**
     * 获取json_obj的json_val
     *
     * @param \FFI\CData $json_obj json_obj
     * @param string $key json_obj的key
     * @return \FFI\CData json_val
     */
    public function objGetVal(\FFI\CData $json_obj, string $key): \FFI\CData
    {
        return $this->ffi->json_object_get_value($json_obj, $key);
    }

    /**
     * 获取json_obj的字符串
     *
     * @param \FFI\CData $json_obj json_obj
     * @param string $key json_obj的key
     * @return string json_obj的字符串值
     */
    public function objGetStr(\FFI\CData $json_obj, string $key): string
    {
        return $this->ffi->json_object_get_string($json_obj, $key);
    }

    /**
     * 获取json_obj的json_obj
     *
     * @param \FFI\CData $json_obj json_obj
     * @param string $key json_obj的key
     * @return \FFI\CData json_obj
     */
    public function objGetObj(\FFI\CData $json_obj, string $key): \FFI\CData
    {
        return $this->ffi->json_object_get_object($json_obj, $key);
    }

    /**
     * 获取json_obj的json_arr
     *
     * @param \FFI\CData $json_obj json_obj
     * @param string $key json_obj的key
     * @return \FFI\CData json_arr
     */
    public function objGetArr(\FFI\CData $json_obj, string $key): \FFI\CData
    {
        return $this->ffi->json_object_get_array($json_obj, $key);
    }

    /**
     * 获取json_obj的数字
     *
     * @param \FFI\CData $json_obj json_obj
     * @param string $key json_obj的key
     * @return float json_obj的数字值
     */
    public function objGetNum(\FFI\CData $json_obj, string $key): float
    {
        return $this->ffi->json_object_get_number($json_obj, $key);
    }

    /**
     * 获取json_obj的布尔值
     *
     * @param \FFI\CData $json_obj json_obj
     * @param string $key json_obj的key
     * @return boolean json_obj的布尔值
     */
    public function objGetBool(\FFI\CData $json_obj, string $key): bool
    {
        $bool = $this->ffi->json_object_get_boolean($json_obj, $key);
        if ($bool == -1) {
            throw new \Exception('The value obtained is not of Boolean type.');
        }
        return $bool ? true : false;
    }
}
