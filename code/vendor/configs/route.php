<?php
// routeの役割は？
// リクエストURLによってindex.phpに返すパラメータを変更する
// 設定より規約

class Route
{
  /**
   * ルーティングを取得
   * @param  string $request_url
   * @return array  $query
   */
  public function getRouting()
  {
    // リクエストURL取得
    $request_url = $_SERVER["REQUEST_URI"];
    // 各module取得
    $module = $this->getModule($request_url);
    // 各クエリ取得
    $query  = $this->getQuery($request_url);
    // モジュール、クエリを返す
    $ret = array(
      'module'     => $module,
      'query'      => $query
    );

    return $ret;
  }

  /**
   * モジュール名を取得
   * @param  string $request_url
   * @return array  $module
   */
  protected function getModule($request_url)
  {
    $val = preg_match_all("/[\/].[a-z]*/", $request_url, $module_name);
    $module_name = $module_name[0];
    for ($i=0; $i < count($module_name); $i++) { 
      $module[] = trim($module_name[$i], "/");  
    }

    return $module;
  }

  /**
   * クエリ名を取得
   * @param  string $request_url
   * @return array  $query
   */
  protected function getQuery($request_url)
  {
    $params = preg_match_all("/[\?].[a-zA-Z0-9&]*/", $request_url, $query_name);

    $query_name = $query_name[0];
    for ($i=0; $i < count($query_name); $i++) { 
      $query[] = trim($query_name[$i], "?");  
    }

    return $query;
  }

  /**
   * ルーティングによって任意のコントローラーを選択
   * @param  mixed $module
   * @return mixed $user_controller
   */
  function selectUserController($module)
  {
    // 大文字変換
    $controller_name = ucfirst($module[0]);
    $controller_path = "./controller/" . $controller_name . "Controller.php";
    $user_controller = require($controller_path);

    return $user_controller;

  }

}
