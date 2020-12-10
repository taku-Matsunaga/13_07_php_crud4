<?php

function connect_to_db(){

// DB接続情報
$dbn = 'mysql:dbname=gsacf_f04_07;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = 'root';

// DB接続
try {
  return new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

}