<?php

declare(strict_types=1);

namespace Workbunny\PJson;

class PJson
{
    protected static ?\FFI $ffi = null;

    /**
     * @param array{lib_path: string} $config
     */
    public function __construct(array $config = [])
    {
        if (!extension_loaded('ffi')) {
            throw new \RuntimeException('FFI extension is not loaded.');
        }
        if (!static::$ffi) {
            $libPath = $config['lib_path'] ?? (
                (DIRECTORY_SEPARATOR === '\\')
                    ? __DIR__ . '/lib/Json.dll'
                    : __DIR__ . '/lib/Json.so'
            );
            static::$ffi = \FFI::cdef(file_get_contents(__DIR__ . '/Json.h'), $libPath);
        }
    }

    public function decode(string $json)
    {
        if (!($object = static::$ffi->json_parse_string($json))) {
            throw new \RuntimeException('json string format error.');
        }
        return match ($type = static::$ffi->json_type($object)) {
            Type::obj->value => static::$ffi->json_value_get_object($object),
            Type::arr->value => static::$ffi->json_value_get_array($object),
            default => throw new \RuntimeException('It must be a regular json object format or a json array format.'),
        };
    }

}
