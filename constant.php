<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

define('DIR_ROOT',dirname(__FILE__));
define('APP_URL',$_SERVER['HTTP_HOST'].'/api');
define('APP_DIR','/api');

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','Test@123');
define('DB_NAME','shoping_cart_api');
