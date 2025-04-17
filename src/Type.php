<?php

// 严格模式
declare(strict_types=1);

namespace Workbunny\PJson;

enum Type: int
{
    case err = -1; // 错误
    case null = 1; // null
    case str = 2; // 字符串
    case num = 3; // 数字
    case obj = 4; // 对象
    case arr = 5; // 数组
    case bool = 6; // 布尔值
}
