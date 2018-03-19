<?php
print "in hasu controller!";
$request_url = $_SERVER["REQUEST_URI"];
$parameters = $_SERVER['QUERY_STRING'];

$file = file_get_contents("./views/hasumin.html");
return $file;