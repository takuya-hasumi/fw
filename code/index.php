<?php
// 読み込み
$route_path = "./configs/route.php";
$route_file = require($route_path);

// テンプレートエンジン的な定義
$pattern_start = '/{{';
$pattern_value = '[a-z]*';
$pattern_end   = '}}/';
$pattern = $pattern_start . $pattern_value . $pattern_end;

// テンプレートエンジン的な置換
$subject = $route_file['file'];
$replacement = "valuable " . $route_file['val'] . "!!!!";
$replace = preg_replace($pattern, $replacement, $subject);

print $replace;
