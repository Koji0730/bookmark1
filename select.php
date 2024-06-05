<?php
//エラー表示
ini_set("display_errors", 1);
include("funcs.php");

//1.  DB接続します
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM bookmark_an_table";
$stmt = $pdo->prepare("$sql");
$status = $stmt->execute();

//３．データ表示
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}

//全データ取得
$values = $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
  div {padding: 10px; font-size: 16px;}
  table {width: 100%; border-collapse: collapse;}
  th, td {border: 1px solid #ddd; padding: 8px;}
  th {background-color: #f2f2f2;}
</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div>
            <a href="index.php">登録画面へ</a>
        </div>
        <div>
            <a href="chart.php">表にする</a>
        </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div class="container jumbotron">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>名前</th>
        <th>タイトル</th>
        <th>ジャンル</th>
        <th>日付</th>
        <th>年代</th>
        <th>評価</th>
        <th>コメント</th>
        <th>更新</th>
        <th>削除</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($values as $value): ?>
      <tr>
        <td><?= $value['id']?></td>
        <td><?= $value['name']?></td>
        <td><?= $value['title']?></td>
        <td><?= $value['genre']?></td>
        <td><?= $value['date']?></td>
        <td><?= $value['age']?></td>
        <td><?= $value['rating']?></td>
        <td><?= $value['comments']?></td>
        <td><a href="detail.php?id=<?=h($value["id"])?>">Update</a></td>
        <td><a href="delete.php?id=<?=h($value["id"])?>">Delete</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>



</body>
</html>
