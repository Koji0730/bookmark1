<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

//エラー表示
ini_set("display_errors", 1);
include("funcs.php");

//1. POSTデータ取得
$name     = $_POST["name"];
$title    = $_POST["title"];
$genre    = $_POST["genre"];
$date     = $_POST["date"];
$age      = $_POST["age"];
$rating   = $_POST["rating"];
$comments = $_POST["comments"];
$id       = $_POST["id"];

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "UPDATE bookmark_an_table SET name=:name,title=:title,genre=:genre,date=:date,age=:age,rating=:rating,comments=:comments WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',     $name,     PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':title',    $title,    PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':genre',    $genre,    PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':date',     $date,     PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':age',      $age,      PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':rating',   $rating,   PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comments', $comments, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id',       $id,       PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("select.php");
}
?>
