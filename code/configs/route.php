<?php
$request_url = $_SERVER["REQUEST_URI"];
// var_dump($request_url);

/* 学習用（実装とは関係なし）
$reg_exp_params = '/^\/[a-z]*\?[0-9a-zA-Z]*$/';
preg_match($reg_exp_params, $request_url, $match);
var_dump($match);
*/

// リクエストURLからコントローラー名とパラメータを取得
$preg_split_url = preg_split("/[\/\?\&]/", $request_url);
// var_dump($preg_split_url);
$controller_name = $preg_split_url[1];
$str = array_shift($preg_split_url);
// var_dump($controller_name);
// var_dump($str);
// var_dump($preg_split_url);

if ($controller_name == "") {
  require("./controller/indexController.php");
} elseif ($controller_name == "hasu") {
  require("./controller/hasuController.php");
} elseif ($controller_name == "oba") {
  require("./controller/obaController.php");
} else {
  require("./controller/defaultController.php");
}
