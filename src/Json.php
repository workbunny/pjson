<?php

// 严格模式
declare(strict_types=1);

namespace Workbunny\PJson;

use \FFI\CData;
use Workbunny\PJson\Type;

class Json extends Base
{
    /**
     * 当前版本号
     *
     * @return string
     */
    public static function version(): string
    {
        return "v0.0.1";
    }

    /**
     * 解析 JSON 字符串为 Json 对象
     *
     * @param string $json JSON 字符串
     * @return CData JSON 对象
     */
    public static function parse(string $json): CData
    {
        $jsonObj = self::ffi()->cJSON_Parse($json);
        if ($jsonObj === null) {
            throw new \Exception("JSON parse error: " . self::ffi()->cJSON_GetErrorPtr());
        }
        return $jsonObj;
    }

    /**
     * 创建 JSON 对象
     *
     * @param mixed $root 内容
     * @return CData JSON 对象
     */
    public static function create(mixed $root): CData
    {
        switch (gettype($root)) {
            case "NULL":
                return self::ffi()->cJSON_CreateNull();
            case "boolean":
                return self::ffi()->cJSON_CreateBool($root ? 1 : 0);
            case "string":
                return self::ffi()->cJSON_CreateString($root);
            case "integer":
                return self::ffi()->cJSON_CreateNumber((float)$root);
            case "double":
                return self::ffi()->cJSON_CreateNumber($root);
            case "array":
                if (count($root) === 0) {
                    return self::ffi()->cJSON_CreateArray();
                } else {
                    $raw = json_encode($root, JSON_UNESCAPED_UNICODE);
                    return self::ffi()->cJSON_CreateRaw($raw);
                }
            case "object":
                if (empty(get_object_vars($root))) {
                    return self::ffi()->cJSON_CreateObject();
                } else {
                    $raw = json_encode($root, JSON_UNESCAPED_UNICODE);
                    return self::ffi()->cJSON_CreateRaw($raw);
                }
            default:
                throw new \Exception("json type error: " . self::ffi()->cJSON_GetErrorPtr());
        }
    }

    /**
     * 获取 JSON 对象的值
     *
     * @param CData $jsonObj JSON 对象
     * @param string|integer $key JSON 键、索引
     * @return CData JSON 对象
     */
    public static function get(CData $jsonObj, string|int $key): CData
    {
        if (is_int($key)) {
            return self::ffi()->cJSON_GetArrayItem($jsonObj, $key);
        } else {
            return self::ffi()->cJSON_GetObjectItem($jsonObj, $key);
        }
    }

    /**
     * 深度获取 JSON 对象的值
     *
     * @param CData $jsonObj JSON 对象
     * @param string $pointer 路径，必须以 / 开头 如：/abc/0/def
     * @param boolean $caseSensitive 是否区分大小写 默认：true
     * @return CData JSON 对象
     */
    public static function deepGet(CData $jsonObj, string $pointer, bool $caseSensitive = true): CData
    {
        if ($caseSensitive) {
            return self::ffi()->cJSONUtils_GetPointerCaseSensitive($jsonObj, $pointer);
        } else {
            return self::ffi()->cJSONUtils_GetPointer($jsonObj, $pointer);
        }
    }
    /**
     * 设置 JSON 对象的值
     *
     * @param CData $jsonObj JSON 对象
     * @param string|integer|CData $key JSON 键、索引或者JSON对象
     * @param CData $item JSON 对象
     * @return bool
     */
    public static function set(CData $jsonObj, string|int|CData $key, CData $item): bool
    {
        if (is_int($key)) {
            $res = self::ffi()->cJSON_ReplaceItemInArray($jsonObj, $key, $item);
        } elseif (is_string($key)) {
            $res = self::ffi()->cJSON_ReplaceItemInObject($jsonObj, $key, $item);
        } else {
            $res = self::ffi()->cJSON_ReplaceItemViaPointer($jsonObj, $key, $item);
        }
        return $res ? true : false;
    }

    /**
     * 深度设置 JSON 对象的值
     *
     * @param CData $jsonObj JSON 对象
     * @param string $pointer 路径，必须以 / 开头 如：/abc/0/def
     * @param CData $item JSON 对象
     * @return bool
     */
    public static function deepSet(CData &$jsonObj, string $pointer, CData $item): bool
    {
        $copy = self::ffi()->cJSON_Duplicate($jsonObj, 1);
        $newObj = self::ffi()->cJSON_CreateArray();
        self::ffi()->cJSONUtils_AddPatchToArray($newObj, "replace", $pointer, $item);
        $res = self::ffi()->cJSONUtils_ApplyPatchesCaseSensitive($copy, $newObj);
        $jsonObj = $copy;
        return $res == 0 ? true : false;
    }

    /**
     * 添加 JSON 对象的值
     *
     * @param CData $jsonObj JSON 对象
     * @param string|CData $strOrItem JSON 键或JSON对象
     * @param CData|null $item JSON 对象
     * @return boolean
     */
    public static function add(CData $jsonObj, string|CData $keyIntItem, ?CData $item = null): bool
    {
        if (is_string($keyIntItem)) {
            $res = self::ffi()->cJSON_AddItemToObject($jsonObj, $keyIntItem, $item);
        } else {
            $res = self::ffi()->cJSON_AddItemToArray($jsonObj, $keyIntItem);
        }
        return $res ? true : false;
    }

    /**
     * 深度添加 JSON 对象的值
     *
     * @param CData $jsonObj JSON 对象
     * @param string $pointer 路径，必须以 / 开头 如：/abc/0/def
     * @param CData $item JSON 对象
     * @return boolean
     */
    public static function deepAdd(CData &$jsonObj, string $pointer, CData $item): bool
    {
        $copy = self::ffi()->cJSON_Duplicate($jsonObj, 1);
        $newObj = self::ffi()->cJSON_CreateArray();
        self::ffi()->cJSONUtils_AddPatchToArray($newObj, "add", $pointer, $item);
        $res = self::ffi()->cJSONUtils_ApplyPatchesCaseSensitive($copy, $newObj);
        $jsonObj = $copy;
        return $res == 0 ? true : false;
    }


    /**
     * 删除 JSON 对象的值
     *
     * @param CData $jsonObj JSON 对象
     * @param string|integer|CData $item JSON 键、索引或 JSON 对象
     * @return void 
     */
    public static function remove(CData $jsonObj, string|int|CData $item): void
    {
        if (is_int($item)) {
            self::ffi()->cJSON_DeleteItemFromArray($jsonObj, $item);
        } elseif (is_string($item)) {
            self::ffi()->cJSON_DeleteItemFromObject($jsonObj, $item);
        } else {
            self::ffi()->cJSON_DetachItemViaPointer($jsonObj, $item);
            self::ffi()->cJSON_Delete($res);
        }
    }

    /**
     * 深度删除 JSON 对象的值
     *
     * @param CData $jsonObj JSON 对象
     * @param string $pointer 路径，必须以 / 开头 如：/abc/0/def
     * @return void
     */
    public static function deepRemove(CData &$jsonObj, string $pointer): void
    {
        $copy = self::ffi()->cJSON_Duplicate($jsonObj, 1);
        $newObj = self::ffi()->cJSON_CreateArray();
        self::ffi()->cJSONUtils_AddPatchToArray($newObj, "remove", $pointer, null);
        $res = self::ffi()->cJSONUtils_ApplyPatchesCaseSensitive($copy, $newObj);
        $jsonObj = $copy;
        if ($res != 0) {
            throw new \Exception("JSON remove error: " . self::ffi()->cJSON_GetErrorPtr());
        }
    }

    /**
     * 复制 JSON 对象
     *
     * @param CData $jsonObj JSON 对象
     * @param boolean $deep 是否深度复制
     * @return CData 新的 JSON 对象
     */
    public static function copy(CData $jsonObj, bool $deep = true): CData
    {
        return self::ffi()->cJSON_Duplicate($jsonObj, $deep ? 1 : 0);
    }

    /**
     * 合并两个 JSON 对象
     *
     * @param CData $jsonObj1 第一个 JSON 对象
     * @param CData $jsonObj2 第二个 JSON 对象
     * @param boolean $caseSensitive 是否区分大小写 默认：true
     * @return CData 合并后的 JSON 对象
     */
    public static function merge(CData $jsonObj1, CData $jsonObj2, bool $caseSensitive = true): CData
    {
        if ($caseSensitive) {
            return self::ffi()->cJSONUtils_MergePatchCaseSensitive($jsonObj1, $jsonObj2);
        } else {
            return self::ffi()->cJSONUtils_MergePatch($jsonObj1, $jsonObj2);
        }
    }

    /**
     * 比较两个 JSON 对象是否相等
     *
     * @param CData $jsonObj1 第一个 JSON 对象
     * @param CData $jsonObj2 第二个 JSON 对象
     * @param boolean $caseSensitive 是否区分大小写 默认：false
     * @return boolean
     */
    public static function compare(
        CData $jsonObj1,
        CData $jsonObj2,
        bool $caseSensitive = false
    ): bool {
        return self::ffi()->cJSON_Compare($jsonObj1, $jsonObj2, $caseSensitive ? 1 : 0) ? true : false;
    }

    /**
     * 检查 JSON 对象是否包含指定键
     *
     * @param CData $jsonObj JSON 对象
     * @param string $key JSON 键
     * @return boolean 
     */
    public static function hasKey(CData $jsonObj, string $key): bool
    {
        return self::ffi()->cJSON_HasObjectItem($jsonObj, $key) ? true : false;
    }

    /**
     * JSON 对象转PHP类型
     *
     * @param CData $jsonObj JSON 对象
     * @return mixed
     */
    public static function val(CData $jsonObj): mixed
    {
        switch ($jsonObj->type) {
            case Type::FALSE->value:
                return false;
            case Type::TRUE->value:
                return true;
            case Type::BOOL->value:
                return $jsonObj->valueint ? true : false;
            case Type::NULL->value:
                return null;
            case Type::NUMBER->value:
                return $jsonObj->valuedouble;
            case Type::STRING->value:
                return $jsonObj->valuestring;
            default:
                throw new \Exception("json type error: Only numbers, strings, null and Boolean types are supported.");
        }
    }

    /**
     * 获取 JSON 对象的长度
     *
     * @param CData $jsonObj JSON 对象
     * @return integer 长度
     */
    public static function count(CData $jsonObj): int
    {
        return self::ffi()->cJSON_GetArraySize($jsonObj);
    }

    /**
     * 检查 JSON 对象的类型
     *
     * @param CData $jsonObj JSON 对象
     * @return string 类型
     */
    public static function check(CData $jsonObj): string
    {
        switch ($jsonObj->type) {
            case Type::INVALID->value:
                return Type::INVALID->name;
            case Type::FALSE->value:
                return Type::FALSE->name;
            case Type::TRUE->value:
                return Type::TRUE->name;
            case Type::BOOL->value:
                return Type::BOOL->name;
            case Type::NULL->value:
                return Type::NULL->name;
            case Type::NUMBER->value:
                return Type::NUMBER->name;
            case Type::STRING->value:
                return Type::STRING->name;
            case Type::ARRAY->value:
                return Type::ARRAY->name;
            case Type::OBJECT->value:
                return Type::OBJECT->name;
            case Type::RAW->value:
                return Type::RAW->name;
            default:
                throw new \Exception("json type error: " . self::ffi()->cJSON_GetErrorPtr());
        }
    }

    /**
     * 补丁
     *
     * @param CData $from JSON 对象
     * @param CData $to JSON 对象
     * @param boolean $caseSensitive 是否区分大小写 默认：true
     * @return CData 补丁JSON对象
     */
    public static function patches(CData $from, CData $to, bool $caseSensitive = true): CData
    {
        if ($caseSensitive) {
            return self::ffi()->cJSONUtils_GeneratePatchesCaseSensitive($from, $to);
        } else {
            return self::ffi()->cJSONUtils_GeneratePatches($from, $to);
        }
    }

    /**
     * 合并补丁
     *
     * @param CData $jsonObj JSON 对象
     * @param CData $patches 补丁对象
     * @param boolean $caseSensitive 是否区分大小写 默认：true
     * @return CData 合并后的 JSON 对象
     */
    public static function mergePatches(CData $jsonObj, CData $patches, $caseSensitive = true): CData
    {
        if ($caseSensitive) {
            return self::ffi()->cJSONUtils_GenerateMergePatchCaseSensitive($jsonObj, $patches);
        } else {
            return self::ffi()->cJSONUtils_GenerateMergePatch($jsonObj, $patches);
        }
    }

    /**
     * 获取 JSON 对象的路径
     *
     * @param CData $jsonObj JSON 对象
     * @param CData $item JSON 对象
     * @return string 路径
     */
    public static function pointerPath(CData $jsonObj, CData $item): string
    {
        return self::ffi()->cJSONUtils_FindPointerFromObjectTo($jsonObj, $item);
    }

    /**
     * 排序 JSON 对象
     *
     * @param CData $jsonObj JSON 对象
     * @param boolean $caseSensitive 是否区分大小写 默认：true
     * @return void
     */
    public static function sort(CData $jsonObj, bool $caseSensitive = true): void
    {
        if ($caseSensitive) {
            self::ffi()->cJSONUtils_SortObjectCaseSensitive($jsonObj);
        } else {
            self::ffi()->cJSONUtils_SortObject($jsonObj);
        }
    }

    /**
     * 删除 JSON 对象
     *
     * @param CData $jsonObj JSON 对象
     * @return void
     */
    public static function delete(CData $jsonObj): void
    {
        self::ffi()->cJSON_Delete($jsonObj);
    }

    /**
     * 压缩 JSON 字符串
     *
     * @param string $jsonStr JSON 字符串
     * @return void
     */
    public static function minify(string $jsonStr): void
    {
        self::ffi()->cJSON_Minify($jsonStr);
    }

    /**
     * 将 JSON 对象转换为 JSON 字符串
     *
     * @param CData $jsonObj JSON 对象
     * @param boolean $isFormat 是否格式化输出 默认为 true
     * @return string
     */
    public static function print(CData $jsonObj, bool $isFormat = true): string
    {
        if ($isFormat) {
            $res = self::ffi()->cJSON_Print($jsonObj);
        } else {
            $res = self::ffi()->cJSON_PrintUnformatted($jsonObj);
        }
        if ($res === null) {
            throw new \Exception("JSON print error: The erroneous JSON object has been deleted.");
        }
        return $res;
    }
}
