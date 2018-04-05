<?php
print "in default controller!";
// viewファイルを呼び出す
$file = file_get_contents("./views/404.html");
return $file;