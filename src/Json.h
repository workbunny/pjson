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

JSON_Value *json_parse_string(const char *string);
JSON_Object *json_value_get_object(const JSON_Value *value);
const char *json_object_get_string(const JSON_Object *object, const char *name);