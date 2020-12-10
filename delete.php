<?php

// // DB接続情報
// $dbn = 'mysql:dbname=gsacf_f04_07;charset=utf8;port=3306;host=localhost';
// $user = 'root';
// $pwd = 'root';

// // DB接続
// try {
//   $pdo = new PDO($dbn, $user, $pwd);
// } catch (PDOException $e) {
//   echo json_encode(["db error" => "{$e->getMessage()}"]);
//   exit();
// }

include('functions.php');
$pdo = connect_to_db();

// SQL作成&実行
$sql = 'DELETE FROM video_table';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); // SQLを実行

header('Location:read.php');
