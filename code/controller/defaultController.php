<?php
print "in default controller!";
$request_url = $_SERVER["REQUEST_URI"];
$parameters = $_SERVER['QUERY_STRING'];

$file = file_get_contents("./views/404.html");
return $file;