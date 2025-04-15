<?php

// 严格模式
declare(strict_types=1);

class Json
{

    private \FFI $ffi;

    public function __construct()
    {

        $header_content = file_get_contents(__DIR__ . '/Json.h');
        $lib_file = dirname(__DIR__) . '/lib/Json.dll';
        $this->ffi = \FFI::cdef($header_content, $lib_file);
    }

    /**
     * 解析json字符串
     *
     * @param string $json
     * @return \FFI\CData
     */
    public function parse(string $json): \FFI\CData
    {
        $json = $this->ffi->json_parse_string($json);
        if ($json === null) {
            throw new \Exception('json parsing failed');
        }
        return $this->ffi->json_value_get_object($json);
    }

    /**
     * 获取json中的字符串
     *
     * @param \FFI\CData $json json对象
     * @param string $key 键名
     * @return string 字符串
     */
    public function getStr(\FFI\CData $json, string $key): string
    {
        return $this->ffi->json_object_get_string($json, $key);
    }
}
