<?php

// DB接続情報
$dbn = 'mysql:dbname=gsacf_f04_07;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = 'root';

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

// SQL作成&実行
$sql = 'SELECT * FROM video_table';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); // SQLを実行

if ($status == false) {
  $error = $stmt->errorInfo();
  exit('sqlError:' . $error[2]);
} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $output = "";
  foreach ($result as $record) {
    $output .= "<div>";
    // var_dump($record["video"]);
    $output .= "<a href='{$record['video']}'>保存した動画</a>";
    $output .= "</div>";
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>保存動画一覧</title>
</head>

<body>
  <fieldset>
    <legend>保存動画一覧</legend>
    <a href="index.php">入力画面</a>
    <div>
      <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
      <?= $output ?>
    </div>
  </fieldset>
</body>

</html>