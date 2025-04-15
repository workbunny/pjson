/*
 SPDX-LicENSE-Identifier: MIT

 Parson 1.5.3 (https://github.com/kgabis/parson)
 版权所有 (c) 2012 - 2023 Krzysztof Gabis

 特此授予任何获得本软件及相关文档文件（以下简称"软件"）副本的个体，
 允许无限制地处理本软件，包括但不限于使用、复制、修改、合并、发布、
 分发、再许可及/或销售本软件的副本，并允许向其提供本软件的个体进行上述操作，
 须遵守以下条件：

 上述版权声明及本许可声明须包含在本软件的所有副本或主要部分中。

 本软件按"原样"提供，不附带任何明示或暗示的担保，包括但不限于适销性担保、
 特定用途适用性担保和非侵权担保。在任何情况下，作者或版权持有人均不对
 任何索赔、损害或其他责任负责，无论该等责任产生于合同、侵权或其他法律行为中，
 且与软件或软件的使用或其他处理行为相关。
*/

#ifndef parson_parson_h
#define parson_parson_h

#ifdef __cplusplus
extern "C"
{
#endif
#if 0
} /* 解决Xcode语法解析冲突 */
#endif

/* 版本定义宏 */
#define PARSON_VERSION_MAJOR 1 /* 主版本号 */
#define PARSON_VERSION_MINOR 5 /* 次版本号 */
#define PARSON_VERSION_PATCH 3 /* 修订号 */

#define PARSON_VERSION_STRING "1.5.3" /* 完整版本字符串 */

#include <stddef.h> /* 包含size_t定义 */

    /*-------------------------------------
     * 类型系统定义
     *------------------------------------*/
    typedef struct json_object_t JSON_Object; /* JSON对象类型 */
    typedef struct json_array_t JSON_Array;   /* JSON数组类型 */
    typedef struct json_value_t JSON_Value;   /* JSON值类型 */

    /* JSON值类型枚举（遵循C90枚举定义规范） */
    enum json_value_type
    {
        JSONError = -1, /* 错误类型 */
        JSONNull = 1,   /* 空值 */
        JSONString = 2, /* 字符串 */
        JSONNumber = 3, /* 数值 */
        JSONObject = 4, /* 对象 */
        JSONArray = 5,  /* 数组 */
        JSONBoolean = 6 /* 布尔值 */
    };
    typedef int JSON_Value_Type; /* 类型别名 */

    /* 操作结果状态码 */
    enum json_result_t
    {
        JSONSuccess = 0, /* 操作成功 */
        JSONFailure = -1 /* 操作失败 */
    };
    typedef int JSON_Status; /* 状态类型别名 */

    /*-------------------------------------
     * 内存管理接口
     *------------------------------------*/
    typedef void *(*JSON_Malloc_Function)(size_t); /* 内存分配函数指针 */
    typedef void (*JSON_Free_Function)(void *);    /* 内存释放函数指针 */

    /* 数字序列化函数原型（符合C90函数指针定义规范）
     * 功能说明：
     *   - 当buf为NULL时，返回所需缓冲区字节数（不超过PARSON_NUM_BUF_SIZE）
     *   - 当buf非空时，执行实际序列化操作
     */
    typedef int (*JSON_Number_Serialization_Function)(double num, char *buf);

    /*-------------------------------------
     * 全局配置函数
     *------------------------------------*/
    /* 设置自定义内存分配器（须在调用其他API前初始化） */
    void json_set_allocation_functions(JSON_Malloc_Function malloc_fun, JSON_Free_Function free_fun);

    /* 设置斜杠转义策略（默认启用）
     * 安全提示：此函数修改全局状态，非线程安全 */
    void json_set_escape_slashes(int escape_slashes);

    /* 设置浮点数序列化格式（需确保格式字符串长度安全） */
    void json_set_float_serialization_format(const char *format);

    /* 设置自定义数字序列化函数 */
    void json_set_number_serialization_function(JSON_Number_Serialization_Function fun);

    /*-------------------------------------
     * 核心功能函数组
     *------------------------------------*/
    /* 文件解析接口（严格遵守C90函数声明规范） */
    JSON_Value *json_parse_file(const char *filename);               /* 无注释解析 */
    JSON_Value *json_parse_file_with_comments(const char *filename); /* 支持注释解析 */

    /* 字符串解析接口 */
    JSON_Value *json_parse_string(const char *string);               /* 无注释解析 */
    JSON_Value *json_parse_string_with_comments(const char *string); /* 支持注释解析 */

    /* 序列化功能组 */
    size_t json_serialization_size(const JSON_Value *value); /* 计算序列化空间 */
    JSON_Status json_serialize_to_buffer(const JSON_Value *value, char *buf, size_t buf_size_in_bytes);
    JSON_Status json_serialize_to_file(const JSON_Value *value, const char *filename);
    char *json_serialize_to_string(const JSON_Value *value);

    /* 带格式化的序列化组（遵循MISRA C代码规范[3](@ref)） */
    size_t json_serialization_size_pretty(const JSON_Value *value);
    JSON_Status json_serialize_to_buffer_pretty(const JSON_Value *value, char *buf, size_t buf_size_in_bytes);
    JSON_Status json_serialize_to_file_pretty(const JSON_Value *value, const char *filename);
    char *json_serialize_to_string_pretty(const JSON_Value *value);

    /* 资源释放函数（符合C90内存管理规范） */
    void json_free_serialized_string(char *string); /* 释放序列化字符串 */

#ifdef __cplusplus
}
#endif

#endif