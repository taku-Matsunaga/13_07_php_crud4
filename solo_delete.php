<?php
include('functions.php');

// idをgetで受け取る
$id = $_GET['id'];

$pdo = connect_to_db();

// idを指定して更新するSQLを作成 -> 実行の処理
$sql = 'DELETE FROM video_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
  } else {
  // 一覧画面にリダイレクト
  header('Location:read.php');
  }