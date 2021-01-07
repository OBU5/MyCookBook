<?php 
ob_start(); // to be able to use $_GET in setcookie 
$cookie_name = "style";
$cookie_value = isset($_GET[$cookie_name]) ? $_GET[$cookie_name] : "default";
echo $cookie_value;
setcookie($cookie_name, $cookie_value);
header("location:index.php");
