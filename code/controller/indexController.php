<?php
print "in index controller!";
// viewファイルを呼び出す
$file = file_get_contents("./views/welcome.html");
return $file;