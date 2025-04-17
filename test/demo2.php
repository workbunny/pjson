<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Workbunny\PJson\Json;
use Workbunny\PJson\Obj;

// pjson解析
$json = Json::decode('{"name":"workbunny","age":18}');
var_dump(Json::encode($json));
