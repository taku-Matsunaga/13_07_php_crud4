<?php

// 各値をpostで受け取る
$username = $_POST['username'];
$password = $_POST['password'];
$is_admin = $_POST['is_admin'];
$id = $_POST['id'];

include('functions.php');
$pdo = connect_to_db();

// idを指定して更新するSQLを作成（UPDATE文）
$sql = "UPDATE users_video_table SET username=:username, password=:password, is_admin=:is_admin,
updated_at=sysdate() WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// 各値をpostで受け取る
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
  } else {
  // 正常に実行された場合は一覧ページファイルに移動し，処理を実行する
  header("Location:admin.php");
  exit();
  }