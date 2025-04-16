/*
 SPDX-License-Identifier: MIT

 Parson 1.5.3 (https://github.com/kgabis/parson)
 版权所有 (c) 2012 - 2023 Krzysztof Gabis

 特此免费授予任何获得本软件及相关文档文件（“软件”）副本的人，
 可以不受限制地处理本软件，包括但不限于使用、复制、修改、合并、发布、分发、
 再许可和/或出售软件副本的权利，并允许向其提供软件的人这样做，
 但需遵守以下条件：

 上述版权声明和本许可声明应包含在所有副本或软件的重要部分中。

 本软件按“原样”提供，不附带任何形式的明示或暗示保证，
 包括但不限于适销性、特定用途适用性和不侵权的保证。
 在任何情况下，作者或版权持有人均不对因合同、侵权或其他方式引起的
 任何索赔、损害或其他责任负责，无论是与软件或软件的使用或其他交易有关。
*/

#ifndef parson_parson_h
#define parson_parson_h

#ifdef __cplusplus
extern "C"
{
#endif
#if 0
} /* 避免Xcode混淆 */
#endif

#define PARSON_VERSION_MAJOR 1
#define PARSON_VERSION_MINOR 5
#define PARSON_VERSION_PATCH 3

#define PARSON_VERSION_STRING "1.5.3"

#include <stddef.h> /* size_t */

   /* 类型和枚举 */
   typedef struct json_object_t JSON_Object;
   typedef struct json_array_t JSON_Array;
   typedef struct json_value_t JSON_Value;

   enum json_value_type
   {
      JSONError = -1,
      JSONNull = 1,
      JSONString = 2,
      JSONNumber = 3,
      JSONObject = 4,
      JSONArray = 5,
      JSONBoolean = 6
   };
   typedef int JSON_Value_Type;

   enum json_result_t
   {
      JSONSuccess = 0,
      JSONFailure = -1
   };
   typedef int JSON_Status;

   typedef void *(*JSON_Malloc_Function)(size_t);
   typedef void (*JSON_Free_Function)(void *);

   /* 用于序列化数字的函数（参见 json_set_number_serialization_function）。
      如果 'buf' 为 NULL，则应返回原本会写入的字节数（但不超过 PARSON_NUM_BUF_SIZE）。
   */
   typedef int (*JSON_Number_Serialization_Function)(double num, char *buf);

   /* 仅在调用 Parson API 的任何其他函数之前调用一次。如果未调用，
      则将使用标准库中的 malloc 和 free 进行所有内存分配 */
   void json_set_allocation_functions(JSON_Malloc_Function malloc_fun, JSON_Free_Function free_fun);

   /* 设置序列化 JSON 时斜杠是否应转义。默认情况下，斜杠会被转义。
    此函数设置全局设置，并且不是线程安全的。 */
   void json_set_escape_slashes(int escape_slashes);

   /* 设置用于数字序列化的浮点格式。
      确保它序列化后的字符串长度不会超过 PARSON_NUM_BUF_SIZE。
      如果格式为 NULL，则使用默认格式。 */
   void json_set_float_serialization_format(const char *format);

   /* 设置用于数字序列化的函数。
      如果函数为 NULL，则使用默认的序列化函数。 */
   void json_set_number_serialization_function(JSON_Number_Serialization_Function fun);

   /* 解析文件中的第一个 JSON 值，出错时返回 NULL */
   JSON_Value *json_parse_file(const char *filename);

   /* 解析文件中的第一个 JSON 值并忽略注释（/ * * / 和 //），
      出错时返回 NULL */
   JSON_Value *json_parse_file_with_comments(const char *filename);

   /*  解析字符串中的第一个 JSON 值，出错时返回 NULL */
   JSON_Value *json_parse_string(const char *string);

   /*  解析字符串中的第一个 JSON 值并忽略注释（/ * * / 和 //），
       出错时返回 NULL */
   JSON_Value *json_parse_string_with_comments(const char *string);

   /* 序列化 */
   size_t json_serialization_size(const JSON_Value *value); /* 失败时返回 0 */
   JSON_Status json_serialize_to_buffer(const JSON_Value *value, char *buf, size_t buf_size_in_bytes);
   JSON_Status json_serialize_to_file(const JSON_Value *value, const char *filename);
   char *json_serialize_to_string(const JSON_Value *value);

   /* 美化序列化 */
   size_t json_serialization_size_pretty(const JSON_Value *value); /* 失败时返回 0 */
   JSON_Status json_serialize_to_buffer_pretty(const JSON_Value *value, char *buf, size_t buf_size_in_bytes);
   JSON_Status json_serialize_to_file_pretty(const JSON_Value *value, const char *filename);
   char *json_serialize_to_string_pretty(const JSON_Value *value);

   void json_free_serialized_string(char *string); /* 释放 json_serialize_to_string 和 json_serialize_to_string_pretty 返回的字符串 */

   /* 比较 */
   int json_value_equals(const JSON_Value *a, const JSON_Value *b);

   /* 验证
      这 *不是* JSON 模式。它通过检查对象是否具有相同名称且类型匹配的字段来验证 JSON。
      例如，模式 {"name":"", "age":0} 可以验证 {"name":"Joe", "age":25} 和 {"name":"Joe", "age":25, "gender":"m"}，
      但不能验证 {"name":"Joe"} 或 {"name":"Joe", "age":"Cucumber"}。
      对于数组，仅检查模式中的第一个值与测试数组中的所有值。
      空对象 ({}) 可以验证所有对象，空数组 ([]) 可以验证所有数组，
      空值 (null) 可以验证所有类型的值。
    */
   JSON_Status json_validate(const JSON_Value *schema, const JSON_Value *value);

   /*
    * JSON 对象
    */
   /* 获取对象中指定名称的值 */
   JSON_Value *json_object_get_value(const JSON_Object *object, const char *name);
   /* 获取对象中指定名称的字符串值 */
   const char *json_object_get_string(const JSON_Object *object, const char *name);
   /* 获取对象中指定名称的字符串长度（不包括末尾的空字符） */
   size_t json_object_get_string_len(const JSON_Object *object, const char *name); 
   /* 获取对象中指定名称的子对象 */
   JSON_Object *json_object_get_object(const JSON_Object *object, const char *name);
   /* 获取对象中指定名称的数组 */
   JSON_Array *json_object_get_array(const JSON_Object *object, const char *name);
   /* 获取对象中指定名称的数字值，失败时返回 0 */
   double json_object_get_number(const JSON_Object *object, const char *name); 
   /* 获取对象中指定名称的布尔值，失败时返回 -1 */
   int json_object_get_boolean(const JSON_Object *object, const char *name);   

   /* 点表示法获取函数允许使用点符号访问嵌套对象中的值，
    就像在结构体或 C++/Java/C# 对象中一样（例如 objectA.objectB.value）。
    由于 JSON 中的有效名称可能包含点，因此某些值可能无法通过这种方式访问。 */
   JSON_Value *json_object_dotget_value(const JSON_Object *object, const char *name);
   const char *json_object_dotget_string(const JSON_Object *object, const char *name);
   size_t json_object_dotget_string_len(const JSON_Object *object, const char *name); /* 不包括末尾的空字符 */
   JSON_Object *json_object_dotget_object(const JSON_Object *object, const char *name);
   JSON_Array *json_object_dotget_array(const JSON_Object *object, const char *name);
   double json_object_dotget_number(const JSON_Object *object, const char *name); /* 失败时返回 0 */
   int json_object_dotget_boolean(const JSON_Object *object, const char *name);   /* 失败时返回 -1 */

   /* 获取可用名称的函数 */
   /* 获取对象中键值对的数量 */
   size_t json_object_get_count(const JSON_Object *object);
   /* 获取对象中指定索引处的键名 */
   const char *json_object_get_name(const JSON_Object *object, size_t index);
   /* 获取对象中指定索引处的值 */
   JSON_Value *json_object_get_value_at(const JSON_Object *object, size_t index);
   /* 获取包装对象的 JSON 值 */
   JSON_Value *json_object_get_wrapping_value(const JSON_Object *object);

   /* 检查对象是否具有特定名称的值的函数。如果对象具有该值，则返回 1，否则返回 0。
    * dothas 函数的行为与 dotget 函数完全相同。 */
   int json_object_has_value(const JSON_Object *object, const char *name);
   int json_object_has_value_of_type(const JSON_Object *object, const char *name, JSON_Value_Type type);

   int json_object_dothas_value(const JSON_Object *object, const char *name);
   int json_object_dothas_value_of_type(const JSON_Object *object, const char *name, JSON_Value_Type type);

   /* 创建新的键值对，或者释放并替换旧值为新值。
    * json_object_set_value 不会复制传入的值，因此之后不应释放该值。 */
   JSON_Status json_object_set_value(JSON_Object *object, const char *name, JSON_Value *value);
   JSON_Status json_object_set_string(JSON_Object *object, const char *name, const char *string);
   JSON_Status json_object_set_string_with_len(JSON_Object *object, const char *name, const char *string, size_t len); /* 长度不应包括末尾的空字符 */
   JSON_Status json_object_set_number(JSON_Object *object, const char *name, double number);
   JSON_Status json_object_set_boolean(JSON_Object *object, const char *name, int boolean);
   JSON_Status json_object_set_null(JSON_Object *object, const char *name);

   /* 行为类似于 dotget 函数，但必要时会创建整个层次结构。
    * json_object_dotset_value 不会复制传入的值，因此之后不应释放该值。 */
   JSON_Status json_object_dotset_value(JSON_Object *object, const char *name, JSON_Value *value);
   JSON_Status json_object_dotset_string(JSON_Object *object, const char *name, const char *string);
   JSON_Status json_object_dotset_string_with_len(JSON_Object *object, const char *name, const char *string, size_t len); /* 长度不应包括末尾的空字符 */
   JSON_Status json_object_dotset_number(JSON_Object *object, const char *name, double number);
   JSON_Status json_object_dotset_boolean(JSON_Object *object, const char *name, int boolean);
   JSON_Status json_object_dotset_null(JSON_Object *object, const char *name);

   /* 释放并移除指定名称的键值对 */
   JSON_Status json_object_remove(JSON_Object *object, const char *name);

   /* 行为类似于 dotget 函数，但仅在精确匹配时移除键值对。 */
   JSON_Status json_object_dotremove(JSON_Object *object, const char *key);

   /* 移除对象中的所有键值对 */
   JSON_Status json_object_clear(JSON_Object *object);

   /*
    *JSON 数组
    */
   /* 获取数组中指定索引处的值 */
   JSON_Value *json_array_get_value(const JSON_Array *array, size_t index);
   /* 获取数组中指定索引处的字符串值 */
   const char *json_array_get_string(const JSON_Array *array, size_t index);
   /* 获取数组中指定索引处的字符串长度（不包括末尾的空字符） */
   size_t json_array_get_string_len(const JSON_Array *array, size_t index); 
   /* 获取数组中指定索引处的对象 */
   JSON_Object *json_array_get_object(const JSON_Array *array, size_t index);
   /* 获取数组中指定索引处的子数组 */
   JSON_Array *json_array_get_array(const JSON_Array *array, size_t index);
   /* 获取数组中指定索引处的数字值，失败时返回 0 */
   double json_array_get_number(const JSON_Array *array, size_t index); 
   /* 获取数组中指定索引处的布尔值，失败时返回 -1 */
   int json_array_get_boolean(const JSON_Array *array, size_t index);   
   /* 获取数组中元素的数量 */
   size_t json_array_get_count(const JSON_Array *array);
   /* 获取包装数组的 JSON 值 */
   JSON_Value *json_array_get_wrapping_value(const JSON_Array *array);

   /* 释放并移除数组中指定索引处的值，如果索引不存在则不执行任何操作并返回 JSONFailure。
    * 数组中值的顺序在执行过程中可能会改变。  */
   JSON_Status json_array_remove(JSON_Array *array, size_t i);

   /* 释放并移除数组中指定索引处的值，并用给定的值替换它。
    * 如果索引不存在则不执行任何操作并返回 JSONFailure。
    * json_array_replace_value 不会复制传入的值，因此之后不应释放该值。 */
   JSON_Status json_array_replace_value(JSON_Array *array, size_t i, JSON_Value *value);
   JSON_Status json_array_replace_string(JSON_Array *array, size_t i, const char *string);
   JSON_Status json_array_replace_string_with_len(JSON_Array *array, size_t i, const char *string, size_t len); /* 长度不应包括末尾的空字符 */
   JSON_Status json_array_replace_number(JSON_Array *array, size_t i, double number);
   JSON_Status json_array_replace_boolean(JSON_Array *array, size_t i, int boolean);
   JSON_Status json_array_replace_null(JSON_Array *array, size_t i);

   /* 释放并移除数组中的所有值 */
   JSON_Status json_array_clear(JSON_Array *array);

   /* 在数组末尾追加新值。
    * json_array_append_value 不会复制传入的值，因此之后不应释放该值。 */
   JSON_Status json_array_append_value(JSON_Array *array, JSON_Value *value);
   JSON_Status json_array_append_string(JSON_Array *array, const char *string);
   JSON_Status json_array_append_string_with_len(JSON_Array *array, const char *string, size_t len); /* 长度不应包括末尾的空字符 */
   JSON_Status json_array_append_number(JSON_Array *array, double number);
   JSON_Status json_array_append_boolean(JSON_Array *array, int boolean);
   JSON_Status json_array_append_null(JSON_Array *array);

   /*
    *JSON 值
    */
   /* 初始化一个 JSON 对象值 */
   JSON_Value *json_value_init_object(void);
   /* 初始化一个 JSON 数组值 */
   JSON_Value *json_value_init_array(void);
   /* 初始化一个 JSON 字符串值，复制传入的字符串 */
   JSON_Value *json_value_init_string(const char *string);                         
   /* 初始化一个 JSON 字符串值，复制传入的字符串，长度不应包括末尾的空字符 */
   JSON_Value *json_value_init_string_with_len(const char *string, size_t length); 
   /* 初始化一个 JSON 数字值 */
   JSON_Value *json_value_init_number(double number);
   /* 初始化一个 JSON 布尔值 */
   JSON_Value *json_value_init_boolean(int boolean);
   /* 初始化一个 JSON 空值 */
   JSON_Value *json_value_init_null(void);
   /* 深度复制一个 JSON 值 */
   JSON_Value *json_value_deep_copy(const JSON_Value *value);
   /* 释放一个 JSON 值 */
   void json_value_free(JSON_Value *value);

   /* 获取 JSON 值的类型 */
   JSON_Value_Type json_value_get_type(const JSON_Value *value);
   /* 获取 JSON 值对应的对象 */
   JSON_Object *json_value_get_object(const JSON_Value *value);
   /* 获取 JSON 值对应的数组 */
   JSON_Array *json_value_get_array(const JSON_Value *value);
   /* 获取 JSON 值对应的字符串 */
   const char *json_value_get_string(const JSON_Value *value);
   /* 获取 JSON 值对应的字符串长度（不包括末尾的空字符） */
   size_t json_value_get_string_len(const JSON_Value *value); 
   /* 获取 JSON 值对应的数字 */
   double json_value_get_number(const JSON_Value *value);
   /* 获取 JSON 值对应的布尔值 */
   int json_value_get_boolean(const JSON_Value *value);
   /* 获取 JSON 值的父值 */
   JSON_Value *json_value_get_parent(const JSON_Value *value);

   /* 与上面的函数相同，但名称更短 */
   JSON_Value_Type json_type(const JSON_Value *value);
   JSON_Object *json_object(const JSON_Value *value);
   JSON_Array *json_array(const JSON_Value *value);
   const char *json_string(const JSON_Value *value);
   size_t json_string_len(const JSON_Value *value); /* 不包括末尾的空字符 */
   double json_number(const JSON_Value *value);
   int json_boolean(const JSON_Value *value);

#ifdef __cplusplus
}
#endif

#endif