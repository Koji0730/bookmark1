<?php
$id = $_GET["id"];
include("funcs.php");
$pdo = db_conn();

// データ登録SQL作成
$sql = "SELECT * FROM bookmark_an_table WHERE id =:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  // Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

// データ表示
$values = "";
if($status==false) {
    sql_error($stmt);
}

// 全データ取得
$v =  $stmt->fetch(); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>データ更新</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="form-container">
        <form action="update.php" method="POST">
            <label for="name">投稿者:</label>
            <input type="text" id="name" name="name" value="<?=$v["name"]?>" required>

            <label for="title">本のタイトル:</label>
            <input type="text" id="title" name="title" value="<?=$v["title"]?>" required>

            <label for="genre">本のジャンル:</label>
            <select id="genre" name="genre" required>
                <option value="">選択してください。</option>
                <option value="fiction" <?=$v["genre"] == "fiction" ? "selected" : ""?>>フィクション</option>
                <option value="nonfiction" <?=$v["genre"] == "nonfiction" ? "selected" : ""?>>ノンフィクション</option>
                <option value="mystery" <?=$v["genre"] == "mystery" ? "selected" : ""?>>ミステリー</option>
                <option value="science" <?=$v["genre"] == "science" ? "selected" : ""?>>科学</option>
                <option value="history" <?=$v["genre"] == "history" ? "selected" : ""?>>歴史</option>
                <option value="philosophy" <?=$v["genre"] == "philosophy" ? "selected" : ""?>>哲学</option>
            </select>

            <label for="date">読んだ日付:</label>
            <input type="date" id="date" name="date" value="<?=$v["date"]?>">

            <label for="age">年代:</label>
            <select id="age" name="age" required>
                <option value="">選択してください。</option>
                <option value="10" <?=($v["age"] == "10") ? "selected" : ""?>>10代</option>
                <option value="20" <?=($v["age"] == "20") ? "selected" : ""?>>20代</option>
                <option value="30" <?=($v["age"] == "30") ? "selected" : ""?>>30代</option>
                <option value="40" <?=($v["age"] == "40") ? "selected" : ""?>>40代</option>
                <option value="50" <?=($v["age"] == "50") ? "selected" : ""?>>50代</option>
                <option value="60" <?=($v["age"] == "60") ? "selected" : ""?>>60歳以上</option>
            </select>

            <label for="rating">本の評価:</label>
            <div class="star-rating-container">
                <div class="star-rating">
                    <?php for ($i = 10; $i >= 1; $i--): ?>
                        <input type="radio" id="star<?=$i?>" name="rating" value="<?=$i?>" <?=$v["rating"] == $i ? "checked" : ""?>><label for="star<?=$i?>">★</label>
                    <?php endfor; ?>
                </div>
            </div>

            <label for="comments">コメント:</label>
            <textarea id="comments" name="comments"><?=$v["naiyou"]?></textarea>
            <input type="hidden" name="id" value="<?=$v["id"]?>">

            <button type="submit">登録</button>
        </form>
    </div>
</body>
</html>
