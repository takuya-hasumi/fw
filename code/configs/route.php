<?php
$request_url = $_SERVER["REQUEST_URI"];

/* 学習用（実装とは関係なし）
$reg_exp_params = '/^\/[a-z]*\?[0-9a-zA-Z]*$/';
preg_match($reg_exp_params, $request_url, $match);
var_dump($match);
*/

// リクエストURLからコントローラー名とパラメータを取得
$preg_split_url = preg_split("/[\/\?\&]/", $request_url);
$controller_name = $preg_split_url[1];
$params = $preg_split_url[2];
$str = array_shift($preg_split_url);

if ($controller_name == "") {
  require("./controller/indexController.php");
} elseif ($controller_name == "hasu") {
  require("./controller/hasuController.php");
} elseif ($controller_name == "oba") {
  require("./controller/obaController.php");
} else {
  require("./controller/defaultController.php");
}

return $params;