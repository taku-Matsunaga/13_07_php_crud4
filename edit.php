<?php

// 関数ファイル読み込み
include("functions.php");

// 送信されたidをgetで受け取る
$id = $_GET['id'];

// DB接続&id名でテーブルから検索
$pdo = connect_to_db();
$sql = 'SELECT * FROM video_table WHERE id=:id';
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
  <title>保存動画（編集画面）</title>
</head>

<body>
  <form action="update.php" method="POST">
    <fieldset>
      <legend>保存動画（編集画面）</legend>
      <a href="read.php">一覧画面</a>
      <div>
        コメント: <input type="text" name="comment" value="<?= $record["comment"] ?>">
      </div>
      <div>
        保存目的: 
        <select name="purpose">
        <option value="<?= $record["purpose"] ?>"><?= $record["purpose"] ?></option>
        <option value="後で観る">後で観る</option>
        <option value="お気に入り">お気に入り</option>
        <option value="共有する">共有する</option>
        <option value="その他">その他</option>
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