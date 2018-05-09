<?php
// ルーティング処理
require("./configs/route.php");
$route = new UserRoute();
$reqParams = $route->getRoute();

// module, queryの取得
$module = $reqParams['module'];
$query  = $reqParams['query'];

// BaseControllerの呼び出し
require("./vendor/controller/BaseController.php");

// 任意のコントローラを選択
$class_name = $route->selectController($module);

// コントローラをもとに実行
$exec = new $class_name();
$exec->execAction();
