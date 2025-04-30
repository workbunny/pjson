typedef struct cJSON
{
    struct cJSON *next;
    struct cJSON *prev;
    struct cJSON *child;
    int type;
    const char *valuestring;
    int valueint;
    double valuedouble;
    const char *string;
} cJSON;
typedef struct cJSON_Hooks
{
    void *(*malloc_fn)(unsigned long long sz);
    void (*free_fn)(void *ptr);
} cJSON_Hooks;
typedef int cJSON_bool;
// 解析
cJSON *cJSON_Parse(const char *value);
const char *cJSON_GetErrorPtr();
const char *cJSON_Print(const cJSON *item);
const char *cJSON_PrintUnformatted(const cJSON *item);
void cJSON_Delete(cJSON *item);
void cJSON_free(void *object);
int cJSON_GetArraySize(const cJSON *array);
void cJSON_Minify(char *json);
// 转换
const char *cJSON_GetStringValue(const cJSON *const item);
double cJSON_GetNumberValue(const cJSON *const item);
// 获取
cJSON *cJSON_GetArrayItem(const cJSON *array, int index);
cJSON *cJSON_GetObjectItem(const cJSON *const object, const char *const string);
// 深度获取
cJSON *cJSONUtils_GetPointer(cJSON *const object, const char *pointer);
cJSON *cJSONUtils_GetPointerCaseSensitive(cJSON *const object, const char *pointer);
// 存在
cJSON_bool cJSON_HasObjectItem(const cJSON *object, const char *string);
// 判断
cJSON_bool cJSON_IsInvalid(const cJSON *const item);
cJSON_bool cJSON_IsFalse(const cJSON *const item);
cJSON_bool cJSON_IsTrue(const cJSON *const item);
cJSON_bool cJSON_IsBool(const cJSON *const item);
cJSON_bool cJSON_IsNull(const cJSON *const item);
cJSON_bool cJSON_IsNumber(const cJSON *const item);
cJSON_bool cJSON_IsString(const cJSON *const item);
cJSON_bool cJSON_IsArray(const cJSON *const item);
cJSON_bool cJSON_IsObject(const cJSON *const item);
cJSON_bool cJSON_IsRaw(const cJSON *const item);
// 创建
cJSON *cJSON_CreateNull();
cJSON *cJSON_CreateBool(cJSON_bool boolean);
cJSON *cJSON_CreateNumber(double num);
cJSON *cJSON_CreateString(const char *string);
cJSON *cJSON_CreateRaw(const char *raw);
cJSON *cJSON_CreateArray(void);
cJSON *cJSON_CreateObject(void);
// 添加
cJSON_bool cJSON_AddItemToArray(cJSON *array, cJSON *item);
cJSON_bool cJSON_AddItemToObject(cJSON *object, const char *string, cJSON *item);
// 移除/分离
cJSON *cJSON_DetachItemViaPointer(cJSON *parent, cJSON *const item);
cJSON *cJSON_DetachItemFromArray(cJSON *array, int which);
void cJSON_DeleteItemFromArray(cJSON *array, int which);
cJSON *cJSON_DetachItemFromObject(cJSON *object, const char *string);
void cJSON_DeleteItemFromObject(cJSON *object, const char *string);
// 复制和比较
cJSON *cJSON_Duplicate(const cJSON *item, cJSON_bool recurse);
cJSON_bool cJSON_Compare(const cJSON *const a, const cJSON *const b, const cJSON_bool case_sensitive);
// 修改
cJSON_bool cJSON_InsertItemInArray(cJSON *array, int which, cJSON *newitem);
cJSON_bool cJSON_ReplaceItemViaPointer(cJSON *const parent, cJSON *const item, cJSON *replacement);
cJSON_bool cJSON_ReplaceItemInArray(cJSON *array, int which, cJSON *newitem);
cJSON_bool cJSON_ReplaceItemInObject(cJSON *object, const char *string, cJSON *newitem);
// 它们返回添加的项，失败时返回NULL。
cJSON *cJSON_AddNullToObject(cJSON *const object, const char *const name);
cJSON *cJSON_AddTrueToObject(cJSON *const object, const char *const name);
cJSON *cJSON_AddFalseToObject(cJSON *const object, const char *const name);
cJSON *cJSON_AddBoolToObject(cJSON *const object, const char *const name, const cJSON_bool boolean);
cJSON *cJSON_AddNumberToObject(cJSON *const object, const char *const name, const double number);
cJSON *cJSON_AddStringToObject(cJSON *const object, const char *const name, const char *const string);
cJSON *cJSON_AddObjectToObject(cJSON *const object, const char *const name);
cJSON *cJSON_AddArrayToObject(cJSON *const object, const char *const name);
// 补丁
cJSON *cJSONUtils_GeneratePatches(cJSON *const from, cJSON *const to);
cJSON *cJSONUtils_GeneratePatchesCaseSensitive(cJSON *const from, cJSON *const to);
// 深度操作
void cJSONUtils_AddPatchToArray(cJSON *const array, const char *const operation, const char *const path, const cJSON *const value);
int cJSONUtils_ApplyPatches(cJSON *const object, const cJSON *const patches);
int cJSONUtils_ApplyPatchesCaseSensitive(cJSON *const object, const cJSON *const patches);
// 合并
cJSON *cJSONUtils_MergePatch(cJSON *target, const cJSON *const patch);
cJSON *cJSONUtils_MergePatchCaseSensitive(cJSON *target, const cJSON *const patch);
// 生成合并补丁
cJSON *cJSONUtils_GenerateMergePatch(cJSON *const from, cJSON *const to);
cJSON *cJSONUtils_GenerateMergePatchCaseSensitive(cJSON *const from, cJSON *const to);
// 获取当前值对应的路径
const char *cJSONUtils_FindPointerFromObjectTo(const cJSON *const object, const cJSON *const target);
// 排序
void cJSONUtils_SortObject(cJSON *const object);
void cJSONUtils_SortObjectCaseSensitive(cJSON *const object);