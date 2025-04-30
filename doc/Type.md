### 枚举类型

```php
/**
 * JSON 数据类型
 *
 * @package Workbunny\PJson
 * @enum Type
 * @value INVALID 0 无效类型
 * @value FALSE 1 False
 * @value TRUE 2 True
 * @value BOOL 3 布尔值
 * @value NULL 4 Null
 * @value NUMBER 8 数字
 * @value STRING 16 字符串
 * @value ARRAY 32 数组
 * @value OBJECT 64 对象
 * @value RAW 128 原始数据
 */
enum Type: int
{
    case INVALID = 0; // 无效类型
    case FALSE = 1; // False
    case TRUE = 2; // True
    case BOOL = 3; // 布尔值
    case NULL = 4; // Null
    case NUMBER = 8; // 数字
    case STRING = 16; // 字符串
    case ARRAY = 32; // 数组
    case OBJECT = 64; // 对象
    case RAW = 128; // 原始数据
}
```