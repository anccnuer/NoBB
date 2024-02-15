<?php
require 'lib/flight/Flight.php';
require 'lib/Medoo/Medoo.php';
use Medoo\Medoo;
require_once 'src/config.php';

// Medoo初始化mysql
$database = new Medoo([
	'type' => 'mysql',
	'host' => DB_HOST,
	'database' => DB_NAME,
	'username' => DB_USER,
	'password' => DB_PASS,
]);
Flight::set('database', $database);//全局注册



// 过滤器，全局开启跨域
Flight::before('start', function(){
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type');
});


Flight::route('/', function(){
  echo 'hello NoBB!';
});

Flight::route('GET /uesMedoo',function(){
  $database = Flight::get('database');
  $users = $database->select('copy', '*');
  Flight::json($users);
});


Flight::start();

