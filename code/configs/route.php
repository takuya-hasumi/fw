<?php
$request_url = $_SERVER["REQUEST_URI"];

$file = "";
if ($request_url == "/") {
  $file = file_get_contents("./views/welcome.html");
  $val = "welcome";
} elseif ($request_url == "/hasumin") {
  $file = file_get_contents("./views/hasumin.html");
  $val = "minhasu";
} elseif ($request_url == "/obachan") {
  $file = file_get_contents("./views/obachan.html");
  $val = "obatarian";
} else {
  $file = file_get_contents("./views/404.html");
  $val = "welcome";
}
$array = array(
  'file' => $file,
  'val'  => $val
);

return $array;