<?php
print "in oba controller!";
$request_url = $_SERVER["REQUEST_URI"];
$parameters = $_SERVER['QUERY_STRING'];

$file = file_get_contents("./views/obachan.html");
return $file;