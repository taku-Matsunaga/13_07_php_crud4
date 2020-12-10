<?php

// 各値をpostで受け取る
$comment = $_POST['comment'];
$purpose = $_POST['purpose'];
$id = $_POST['id'];

include('functions.php');
$pdo = connect_to_db();

// idを指定して更新するSQLを作成（UPDATE文）
$sql = "UPDATE video_table SET comment=:comment, purpose=:purpose,
updated_at=sysdate() WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':purpose', $purpose, PDO::PARAM_STR);
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
  header("Location:read.php");
  exit();
  }