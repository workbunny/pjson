<?php

// 严格模式
declare(strict_types=1);

namespace Workbunny\PJson;

abstract class Base
{
    protected static \FFI $ffi;

    public static function ffi(): \FFI
    {
        if (!isset(self::$ffi)) {
            $header_content = file_get_contents(__DIR__ . '/Json.h');
            self::$ffi = \FFI::cdef($header_content, self::getLibFile());
        }
        return self::$ffi;
    }

    private static function getLibFile(): string
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
}
