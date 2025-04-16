typedef struct json_string
{
    char *chars;
    size_t length;
} JSON_String;

typedef struct json_object_t JSON_Object;

typedef struct json_value_t JSON_Value;

typedef struct json_array_t JSON_Array;

struct json_object_t
{
    JSON_Value *wrapping_value;
    size_t *cells;
    unsigned long *hashes;
    char **names;
    JSON_Value **values;
    size_t *cell_ixs;
    size_t count;
    size_t item_capacity;
    size_t cell_capacity;
};

typedef union json_value_value
{
    JSON_String string;
    double number;
    JSON_Object *object;
    JSON_Array *array;
    int boolean;
    int null;
} JSON_Value_Value;

struct json_value_t
{
    JSON_Value *parent;
    int type;
    JSON_Value_Value value;
};

struct json_array_t
{
    JSON_Value *wrapping_value;
    JSON_Value **items;
    size_t count;
    size_t capacity;
};

// 解析json字符串，返回json_val结构体
JSON_Value *json_parse_string(const char *string);
// json_val结构体转json_obj结构体
JSON_Object *json_value_get_object(const JSON_Value *value);

// json_obj结构体操作----------------

// 获取json_obj结构体中的json_val结构体
JSON_Value *json_object_get_value(const JSON_Object *object, const char *name);

// 获取json_obj结构体中的字符串
const char *json_object_get_string(const JSON_Object *object, const char *name);

/* 获取对象中指定名称的子对象 */
JSON_Object *json_object_get_object(const JSON_Object *object, const char *name);

/* 获取对象中指定名称的数组 */
JSON_Array *json_object_get_array(const JSON_Object *object, const char *name);

/* 获取对象中指定名称的数字值，失败时返回 0 */
double json_object_get_number(const JSON_Object *object, const char *name);

/* 获取对象中指定名称的布尔值，失败时返回 -1 */
int json_object_get_boolean(const JSON_Object *object, const char *name);