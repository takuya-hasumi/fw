<?php
/*
 * コントローラを介してHTMLファイルの読み込み
 * @return string $file 読み込みHTMLファイル内容
 * @return string $params URLパラメータ
 */
$route_path = "./configs/route.php";
$route_file = require($route_path);

// テンプレートエンジン的な定義
$pattern_value = '[a-z]*';
$pattern = '/{{' . $pattern_value . '}}/';

// テンプレートエンジン的な置換
$subject = $file;
$replacement = "reg " . $params . "!!";
$replace = preg_replace($pattern, $replacement, $subject);

// 最終的なファイルの出力
print $replace;
