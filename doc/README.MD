## 文档说明

### 安装

```bash
composer require workbunny/pjson
```

### 引入

```php
// 引入 Composer 自动加载文件,根据你的实际情况修改路径
require './vendor/autoload.php';

use Workbunny\PJson\Json; // 解析json
use Workbunny\PJson\Arr; //json数组处理
use Workbunny\PJson\Obj; //json对象处理
```

### 类型使用

[Json](Json.md) `Json::xxx(mixed)`

[Arr](Arr.md) `Arr::xxx(mixed)`

[Obj](Obj.md) `Obj::xxx(mixed)`
