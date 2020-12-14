<?php

session_start();

include('functions.php');
$pdo = connect_to_db();

// SQL作成&実行
$sql = 'SELECT * FROM users_video_table';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); // SQLを実行

if ($status == false) {
  $error = $stmt->errorInfo();
  exit('sqlError:' . $error[2]);
} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $output = "";
  foreach ($result as $record) {
    $output .= "<div class = 'outBox'>";
    // var_dump($record["thumb"]);
    $output .= "<p>id : {$record['id']}</p>";
    $output .= "<p>ユーザーネーム : {$record['username']}</p>";
    $output .= "<p>管理者権限 : {$record['is_admin']}</p>";

    $output .= "<div class = 'choiceBtn'><a href='user_edit.php?id={$record["id"]}'>Edit</a></div>";
    $output .= "<div class = 'choiceBtn'><a href='user_delete.php?id={$record["id"]}'>Delete</a></div>";

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
  <style>

    .outBox {
      border: 1px solid #666;
      padding: 10px;
      margin: 10px;
    }

    .choiceBtn {
      text-align: center;
      font-weight: bold;
    }

    .tac {
      text-align: center;
    }
  </style>
</head>

<body>
  <fieldset>
    <legend>登録ユーザー一覧</legend>

    <?php if ($_SESSION["username_id"] == '') : ?>
      <a class="indexBtn" href="login.php">ログイン画面へ</a>
    <?php else : ?>
      <a class="indexBtn" href="search.php">入力画面</a>
    <?php endif ?>

    <div class="innerBox">
      <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
      <?= $output ?>
    </div>

  </fieldset>
</body>

</html>