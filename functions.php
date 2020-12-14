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

// ログイン状態のチェック関数
function check_session_id()
{
  // 失敗時はログイン画面に戻る
if (!isset($_SESSION['session_id']) || // session_idがない
$_SESSION['session_id'] != session_id()// idが一致しない
) {
header('Location:login.php'); // ログイン画面へ移動
} else {
session_regenerate_id(true); // セッションidの再生成
$_SESSION['session_id'] = session_id(); // セッション変数上書き
}
}