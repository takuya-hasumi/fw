<?php
// 読み込み
$route_path = "./configs/route.php";
$ret = require($route_path);

// テンプレートエンジン的な定義
$pattern_start = '/{{';
$pattern_value = '[a-z]*';
$pattern_end   = '}}/';
$pattern = $pattern_start . $pattern_value . $pattern_end;

// テンプレートエンジン的な置換
$subject = $ret['file'];
$replacement = "valuable " . $ret['val'] . "!!!!";
$replace = preg_replace($pattern, $replacement, $subject);

print $replace;
