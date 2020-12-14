<?php

// 関数ファイル読み込み
include("functions.php");

// 送信されたidをgetで受け取る
$id = $_GET['id'];

// DB接続&id名でテーブルから検索
$pdo = connect_to_db();
$sql = 'SELECT * FROM users_video_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// fetch()で1レコード取得できる．
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
  } else {
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  ?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー情報（編集画面）</title>
</head>

<body>
  <form action="user_update.php" method="POST">
    <fieldset>
      <legend>ユーザー情報（編集画面）</legend>
      <a href="admin.php">ユーザー一覧画面</a>
      <div>
        ユーザー名: <input type="text" name="username" value="<?= $record["username"] ?>">
      </div>
      <div>
        パスワード: <input type="text" name="password">
      </div>
      <div>
        保存目的: 
        <select name="is_admin">
        <option value=0>管理者権限無し</option>
        <option value=1>管理者権限有り</option>
        </select>
      </div>
      <div>
        <button>submit</button>
      </div>
      <input type="hidden" name="id" value="<?=$record['id']?>">
    </fieldset>
  </form>

</body>

</html>