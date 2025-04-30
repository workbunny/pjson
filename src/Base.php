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
        static $libFile = null;
        if ($libFile !== null) {
            return $libFile;
        }

        $suffix = [
            'Linux' => '.so',
            'Darwin' => '.dylib',
        ][PHP_OS] ?? '.dll';

        $libFile = dirname(__DIR__) . '/lib/Json' . $suffix;
        return $libFile;
    }
}
