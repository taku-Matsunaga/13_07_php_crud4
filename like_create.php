<?php

// まずはこれ
// var_dump($_GET);
// exit();

// 関数ファイルの読み込み
include('functions.php');

// GETデータ取得
$user_id = $_GET['user_id'];
$video_id = $_GET['video_id'];

// DB接続
$pdo = connect_to_db();

// いいね状態のチェック（COUNTで件数を取得できる！）
$sql = 'SELECT COUNT(*) FROM video_like_table WHERE user_id=:user_id AND video_id=:video_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':video_id', $video_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
// エラー処理
} else {
$like_count = $stmt->fetch();
// var_dump($like_count[0]); // データの件数を確認しよう！
// exit();

// いいねしていれば削除，していなければ追加のSQLを作成
if ($like_count[0] != 0) {
  $sql = 'DELETE FROM video_like_table WHERE user_id=:user_id AND video_id=:video_id';
  } else {
  $sql = 'INSERT INTO video_like_table(id, user_id, video_id, created_at) VALUES(NULL, :user_id, :video_id, sysdate())';
  }
}


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':video_id', $video_id, PDO::PARAM_INT);
$status = $stmt->execute(); // SQL実行

if ($status == false) {
// エラー処理
} else {
header('Location:read.php');
}