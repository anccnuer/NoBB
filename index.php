<?php
require 'lib/flight/Flight.php';
require 'lib/Medoo/Medoo.php';
use Medoo\Medoo;
require_once 'config.php';

// Medoo初始化mysql
$database = new Medoo([
	'type' => 'mysql',
	'host' => 'DB_HOST',
	'database' => 'DB_USER',
	'username' => 'DB_NAME',
	'password' => 'DB_PASS',
]);
Flight::set('database', $database);//全局注册



// 过滤器，全局开启跨域
Flight::before('start', function(){
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type');
});


Flight::route('/', function(){
  echo 'hello world!';
});

Flight::route('/get', function(){
  $db = Flight::db();
  $stmt = $db->query('SELECT * FROM copy');
  $stmt->execute();
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  Flight::json($data);
});

Flight::route('POST /change', function(){
  $db = Flight::db();
  $value = Flight::request()->data->value;
  $stmt = $db->prepare('UPDATE copy SET value = :value WHERE id = 1');
  $stmt->bindParam(':value', $value, PDO::PARAM_STR);
  $stmt->execute();
  Flight::json($value);
});

Flight::route('GET /uesMedoo',function(){
  $database = Flight::get('database');
  $users = $database->select('copy', '*');
  Flight::json($users);
});


Flight::start();

