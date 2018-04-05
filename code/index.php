<?php
// ルーティング処理
require("./configs/route.php");
$route = new UserRoute();
$routing = $route->getRouting();

// module, queryの取得
$module = $routing['module'];
$query  = $routing['query'];

// 任意のコントローラを処理
require("./vendor/controller/BaseController.php");
$user_controller = $route->selectUserController($module);

$class_name = ucfirst($module[0]) . "Controller";
$exec = new $class_name();
$exec->Action();
