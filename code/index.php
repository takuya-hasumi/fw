<?php
// ルーティング処理
require("./configs/route.php");
$route = new UserRoute();
$reqParams = $route->getRoute();

// module, queryの取得
$module = $reqParams['module'];
$query  = $reqParams['query'];

// 任意のコントローラを選択
require("./vendor/controller/BaseController.php");
$class_name = $route->selectController($module);

// コントローラをもとに実行
$exec = new $class_name();
$exec->Action();
