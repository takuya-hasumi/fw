<?php

// ルーティング処理を実行
$route = execRouting();
// ルーティング処理を元にパラメータを取得
$params = getParams($route);
// クラス名の読み込み
$class_name = getClass($route, $params);
// クラス名を元にコントローラを実行
execController($class_name);

/**
 * ルーティング処理を実行
 * @return Route $route ルートオブジェクト
 */
function execRouting()
{
    // ルーティング処理
    require("./configs/route.php");
    $route = new Route();

    return $route;

}

/**
 * ルーティング処理を元にパラメータを取得
 * @param  Route $route　ルーティングオブジェクト
 * @return array $params コントローラとクエリーが格納された連想配列
 */
function getParams($route)
{
    $params = $route->getRoute();
    return $params;
}

/**
 * クラス名を取得
 * @param  Route $route　ルーティングオブジェクト
 * @param  array $params コントローラとクエリーが格納された連想配列
 * @return string $class_name
 */
function getClass($route, $params)
{
    // BaseControllerの呼び出し
    require("./vendor/controller/BaseController.php");
    require("./vendor/controller/DbController.php");
    // 任意のコントローラを選択
    $controller = $route->selectController($params['controller']);
    // クラス名を取得
    $class_name = $route->getClassName($controller);

    return $class_name;
}

/**
 * クラス名をもとにコントローラを実行
 * @param  string $class_name
 */
function execController($class_name)
{
    // コントローラのアクションを実行
    $exec = new $class_name();
    $exec->execAction();

}
