<?php
session_start();
include('functions.php');

// // idをgetで受け取る
// $id = $_GET['id'];

$pdo = connect_to_db();

// ユーザ名取得
$user_id = $_SESSION['username_id'];

$pdo = connect_to_db();

// idを指定して更新するSQLを作成 -> 実行の処理
$sql = 'SELECT * FROM video_table LEFT OUTER JOIN (SELECT video_id, COUNT(id) AS cnt FROM video_like_table GROUP BY video_id) AS likes ON video_table.id = likes.video_id ORDER BY cnt desc';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  exit('sqlError:' . $error[2]);
} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $output = "";
  foreach ($result as $record) {
    $output .= "<div class = 'outBox'>";
    $output .= "<div>";
    $output .= "<div class = 'thumbTitle'>";
    // var_dump($record["thumb"]);
    $output .= "<img src='{$record['thumb']}' />";
    $output .= "<a href='{$record['video']}'>{$record['title']}</a>";
    $output .= "</div>";
    $output .= "<div class = 'likeBtn'><a href='like_create.php?user_id={$user_id}&video_id={$record["id"]}'>{$record["cnt"]}Like</a></div>";
    $output .= "<div>コメント<div class = 'commentArea'>{$record['comment']}</div></div>";
    $output .= "<div>保存目的<div class = 'purposeArea'>{$record['purpose']}</div></div>";
    $output .= "</div>";

    if ($_SESSION["username_id"] == $record['user_id']) {
      $output .= "<div class = 'choiceBtn'><a href='edit.php?id={$record["id"]}'>Edit</a></div>";
      $output .= "<div class = 'choiceBtn'><a href='solo_delete.php?id={$record["id"]}'>Delete</a></div>";
    }

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
    .innerBox {
      width: 70%;
      margin: auto;
    }

    .outBox {
      border: 1px solid #666;
      padding: 10px;
      margin: 10px;
    }

    .thumbTitle {
      display: flex;
    }

    .thumbTitle img {
      width: 30%;
    }

    .thumbTitle a {
      width: 60%;
      margin: auto;
    }

    .commentArea {
      background-color: aliceblue;
      margin: 10px;
      padding: 10px;
    }

    .purposeArea {
      background-color: lavenderblush;
      margin: 10px;
      padding: 10px;
    }

    .indexBtn {
      display: block;
      text-align: center;
      font-size: 1.5rem;
      font-weight: bold;
    }

    .choiceBtn {
      text-align: center;
      font-weight: bold;
    }

    .tac {
      text-align: center;
    }

    .likeBtn {
      text-align: center;
      margin: 10px;
    }

    .likeBtn a {
      color: white;
      background-color: cornflowerblue;
      padding: 10px;
      border-radius: 10px;
      font-weight: bold;
      box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.4);
    }
  </style>
</head>

<body>
  <fieldset>
    <legend>保存動画一覧</legend>

    <?php if ($_SESSION["username_id"] == '') : ?>
      <a class="indexBtn" href="login.php">ログイン画面へ</a>
    <?php else : ?>
      <a class="indexBtn" href="search.php">入力画面</a>
    <?php endif ?>
    <div>
      <a href="sortlist.php">人気順に表示する</a>
    </div>

    <div class="innerBox">
      <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
      <?= $output ?>
    </div>

    <?php if (!$_SESSION["username_id"] == '') : ?>

      <div class="tac">
        <a href="delete.php">全て削除する</a>
      </div>

    <?php endif ?>
  </fieldset>
</body>

</html>