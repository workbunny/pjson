<?php

// 严格模式
declare(strict_types=1);

namespace Workbunny\PJson;

/**
 * json_obj对象操作类
 */
class Obj extends Base
{
    /**
     * json_obj对象转换为json_val对象
     *
     * @param \FFI\CData $json_obj json_obj对象
     * @return \FFI\CData json_val对象
     */
    public static function toVal(\FFI\CData $json_obj): \FFI\CData
    {
        return self::ffi()->json_object_get_wrapping_value($json_obj);
    }

    /**
     * 获取json对象的值
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return \FFI\CData json_val对象
     */
    public static function getVal(\FFI\CData $json_obj, string $key): \FFI\CData
    {
        $json_val = self::ffi()->json_object_get_value($json_obj, $key);
        if ($json_val == null) {
            throw new \Exception("Failed to obtain a value. Procedure.");
        }
        return $json_val;
    }

    /**
     * 获取json对象的字符串值
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return string 字符串值
     */
    public static function getStr(\FFI\CData $json_obj, string $key): string
    {
        return self::ffi()->json_object_get_string($json_obj, $key);
    }

    /**
     * 获取json对象中的json对象
     *
     * @param \FFI\CData $json_obj
     * @param string $key
     * @return \FFI\CData
     */
    public static function getObj(\FFI\CData $json_obj, string $key): \FFI\CData
    {
        return self::ffi()->json_object_get_object($json_obj, $key);
    }

    /**
     * 获取json对象的json数组对象
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return \FFI\CData json数组对象
     */
    public static function getArr(\FFI\CData $json_obj, string $key): \FFI\CData
    {
        return self::ffi()->json_object_get_array($json_obj, $key);
    }

    /**
     * 获取json对象的布尔值
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return boolean 布尔值
     */
    public static function getBool(\FFI\CData $json_obj, string $key): bool
    {
        $bool = self::ffi()->json_object_get_boolean($json_obj, $key);
        if ($bool == -1) {
            throw new \Exception('Failed to obtain a Boolean value. Procedure.');
        }
        return $bool ? true : false;
    }

    /**
     * 获取json对象的数字值, 失败时返回 0
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return float 数字值
     */
    public static function getNum(\FFI\CData $json_obj, string $key): float
    {
        return self::ffi()->json_object_get_number($json_obj, $key);
    }

    /**
     * 获取json对象的值。
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return \FFI\CData json_val对象
     */
    public static function DotgetVal(\FFI\CData $json_obj, string $key): \FFI\CData
    {
        $json_val = self::ffi()->json_object_dotget_value($json_obj, $key);
        if ($json_val == null) {
            throw new \Exception("Failed to obtain a value. Procedure.");
        }
        return $json_val;
    }

    /**
     * 获取json对象的字符串值。
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return string 字符串值
     */
    public static function DotgetStr(\FFI\CData $json_obj, string $key): string
    {
        return self::ffi()->json_object_dotget_string($json_obj, $key);
    }

    /**
     * 获取json对象中的json对象。
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return \FFI\CData json对象
     */
    public static function DotgetObj(\FFI\CData $json_obj, string $key): \FFI\CData
    {
        return self::ffi()->json_object_dotget_object($json_obj, $key);
    }

    /**
     * 获取json对象的json数组对象。
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return \FFI\CData json数组对象
     */
    public static function DotgetArr(\FFI\CData $json_obj, string $key): \FFI\CData
    {
        return self::ffi()->json_object_dotget_array($json_obj, $key);
    }

    /**
     * 获取json对象的布尔值。
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return boolean 布尔值
     */
    public static function DotgetBool(\FFI\CData $json_obj, string $key): bool
    {
        $bool = self::ffi()->json_object_dotget_boolean($json_obj, $key);
        if ($bool == -1) {
            throw new \Exception('Failed to obtain a Boolean value. Procedure.');
        }
        return $bool ? true : false;
    }

    /**
     * 获取json对象的数字值, 失败时返回 0。
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return float 数字值
     */
    public static function DotgetNum(\FFI\CData $json_obj, string $key): float
    {
        return self::ffi()->json_object_dotget_number($json_obj, $key);
    }

    /**
     * 获取对象中键值对的数量
     * 
     * @param \FFI\CData $json_obj json对象
     * @return integer 键值对的数量
     */
    public static function getCount(\FFI\CData $json_obj): int
    {
        return self::ffi()->json_object_get_count($json_obj);
    }

    /**
     * 获取对象中指定索引处的键名
     *
     * @param \FFI\CData $json_obj json对象
     * @param integer $index 索引
     * @return string 键名
     */
    public static function getKey(\FFI\CData $json_obj, int $index): string
    {
        return self::ffi()->json_object_get_name($json_obj, $index);
    }

    /**
     * 检查json对象中的键是否存在
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return boolean true 存在 false 不存在
     */
    public static function has(\FFI\CData $json_obj, string $key): bool
    {
        $bool = self::ffi()->json_object_has_value($json_obj, $key);
        return $bool ? true : false;
    }

    /**
     * 检查json对象中的键是否存在
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return boolean true 存在 false 不存在
     */
    public static function DotHas(\FFI\CData $json_obj, string $key): bool
    {
        $bool = self::ffi()->json_object_dothas_value($json_obj, $key);
        return $bool ? true : false;
    }

    /**
     * 检查json对象中的键是否存在
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @param Type $type 类型
     * @return boolean true 存在 false 不存在
     */
    public static function hasType(\FFI\CData $json_obj, string $key, Type $type): bool
    {
        $bool = self::ffi()->json_object_has_value_of_type($json_obj, $key, $type->value);
        return $bool ? true : false;
    }

    /**
     * 检查json对象中的键是否存在
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @param Type $type 类型
     * @return boolean true 存在 false 不存在
     */
    public static function DotHasType(\FFI\CData $json_obj, string $key, Type $type): bool
    {
        $bool = self::ffi()->json_object_dothas_value_of_type($json_obj, $key, $type->value);
        return $bool ? true : false;
    }

    /**
     * 设置json对象中的键值对内容为新的json对象
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @param \FFI\CData $son_json_obj json对象
     * @return void
     */
    public static function setObj(\FFI\CData $json_obj, string $key, \FFI\CData $son_json_obj): void
    {
        $json_val = self::ffi()->json_object_get_wrapping_value($son_json_obj);
        $res = self::ffi()->json_object_set_value($json_obj, $key, $json_val);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json object.');
        }
    }

    /**
     * 设置json对象中的键值对内容为新的json字符串
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @param string $value 字符串
     * @return void
     */
    public static function setStr(\FFI\CData $json_obj, string $key, string $value): void
    {
        $res = self::ffi()->json_object_set_string($json_obj, $key, $value);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json string.');
        }
    }

    /**
     * 设置json对象中的键值对内容为新的json数组对象
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @param \FFI\CData $son_json_arr json数组对象
     * @return void
     */
    public static function setArr(\FFI\CData $json_obj, string $key, \FFI\CData $son_json_arr): void
    {
        $json_val = self::ffi()->json_array_get_wrapping_value($son_json_arr);
        $res = self::ffi()->json_object_set_value($json_obj, $key, $json_val);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json array.');
        }
    }

    /**
     * 设置json对象中的键值对内容为新的json数字
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @param float $num 数字
     * @return void
     */
    public static function setNum(\FFI\CData $json_obj, string $key, float $num): void
    {
        $res = self::ffi()->json_object_set_number($json_obj, $key, $num);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json number.');
        }
    }

    /**
     * 设置json对象中的键值对内容为新的json布尔值
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @param boolean $bool 布尔值
     * @return void
     */
    public static function setBool(\FFI\CData $json_obj, string $key, bool $bool): void
    {
        $res = self::ffi()->json_object_set_boolean($json_obj, $key, $bool ? 1 : 0);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json boolean.');
        }
    }

    /**
     * 设置json对象中的键值对内容为新的json null
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return void
     */
    public static function setNull(\FFI\CData $json_obj, string $key): void
    {
        $res = self::ffi()->json_object_set_null($json_obj, $key);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json null.');
        }
    }

    /**
     * 设置json对象中的键值对内容为新的json对象
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @param \FFI\CData $son_json_obj json对象
     * @return void
     */
    public static function DotSetObj(\FFI\CData $json_obj, string $key, \FFI\CData $son_json_obj): void
    {
        $json_val = self::ffi()->json_object_get_wrapping_value($son_json_obj);
        $res = self::ffi()->json_object_dotset_value($json_obj, $key, $json_val);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json object.');
        }
    }

    /**
     * 设置json对象中的键值对内容为新的json字符串
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @param string $value 字符串
     * @return void
     */
    public static function DotSetStr(\FFI\CData $json_obj, string $key, string $value): void
    {
        $res = self::ffi()->json_object_dotset_string($json_obj, $key, $value);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json string.');
        }
    }

    /**
     * 设置json对象中的键值对内容为新的json数组对象
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @param \FFI\CData $son_json_arr json数组对象
     * @return void
     */
    public static function DotSetArr(\FFI\CData $json_obj, string $key, \FFI\CData $son_json_arr): void
    {
        $json_val = self::ffi()->json_array_get_wrapping_value($son_json_arr);
        $res = self::ffi()->json_object_dotset_value($json_obj, $key, $json_val);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json array.');
        }
    }

    /**
     * 设置json对象中的键值对内容为新的json数字
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @param float $num 数字
     * @return void
     */
    public static function DotSetNum(\FFI\CData $json_obj, string $key, float $num): void
    {
        $res = self::ffi()->json_object_dotset_number($json_obj, $key, $num);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json number.');
        }
    }

    /**
     * 设置json对象中的键值对内容为新的json布尔值
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @param boolean $bool 布尔值
     * @return void
     */
    public static function DotSetBool(\FFI\CData $json_obj, string $key, bool $bool): void
    {
        $res = self::ffi()->json_object_dotset_boolean($json_obj, $key, $bool ? 1 : 0);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json boolean.');
        }
    }

    /**
     * 设置json对象中的键值对内容为新的json null
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *  
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return void
     */
    public static function DotSetNull(\FFI\CData $json_obj, string $key): void
    {
        $res = self::ffi()->json_object_dotset_null($json_obj, $key);
        if ($res !== 0) {
            throw new \Exception('Failed to set the new json null.');
        }
    }

    /**
     * 移除指定名称的键值对
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return void
     */
    public static function remove(\FFI\CData $json_obj, string $key): void
    {
        $res = self::ffi()->json_object_remove($json_obj, $key);
        if ($res !== 0) {
            throw new \Exception('Failed to remove the key.');
        }
    }

    /**
     * 移除指定名称的键值对
     * 点表示法获取函数允许使用点符号访问嵌套对象中的值。
     * 例如(objectA.objectB.value)。
     * 由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。
     *
     * @param \FFI\CData $json_obj json对象
     * @param string $key 键名
     * @return void
     */
    public static function dotRemove(\FFI\CData $json_obj, string $key): void
    {
        $res = self::ffi()->json_object_dotremove($json_obj, $key);
        if ($res !== 0) {
            throw new \Exception('Failed to remove the key.');
        }
    }

    /**
     * 移除对象中的所有键值对
     *
     * @param \FFI\CData $json_obj json对象
     * @return void
     */
    public static function clear(\FFI\CData $json_obj): void
    {
        $res = self::ffi()->json_object_clear($json_obj);
        if ($res !== 0) {
            throw new \Exception('Failed to clear the json object.');
        }
    }
}
