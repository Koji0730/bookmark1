<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ブックマークシステム</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>

    <div class="form-container">
        <form action="insert.php" method="POST">
            <label for="name">投稿者:</label>
            <input type="text" id="name" name="name" required>

            <label for="title">本のタイトル:</label>
            <input type="text" id="title" name="title" required>

            <label for="genre">本のジャンル:</label>
            <select id="genre" name="genre" required>
                <option>選択してください。</option>
                <option value="fiction">フィクション</option>
                <option value="nonfiction">ノンフィクション</option>
                <option value="mystery">ミステリー</option>
                <option value="science">科学</option>
                <option value="history">歴史</option>
                <option value="philosophy">哲学</option>
            </select>

            <label for="date">読んだ日付:</label>
            <input type="date" id="date" name="date">

            <label for="age">年代:</label>
            <select id="age" name="age" required>
                <option value="">選択してください。</option>
                <option value="10s">10代</option>
                <option value="20s">20代</option>
                <option value="30s">30代</option>
                <option value="40s">40代</option>
                <option value="50s">50代</option>
                <option value="60s_and_above">60歳以上</option>
            </select>

            <label for="rating">本の評価:</label>
            <div class="star-rating-container">
                <div class="star-rating">
                    <input type="radio" id="star10" name="rating" value="10"><label for="star10">★</label>
                    <input type="radio" id="star9" name="rating" value="9"><label for="star9">★</label>
                    <input type="radio" id="star8" name="rating" value="8"><label for="star8">★</label>
                    <input type="radio" id="star7" name="rating" value="7"><label for="star7">★</label>
                    <input type="radio" id="star6" name="rating" value="6"><label for="star6">★</label>
                    <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                </div>
            </div>
            <label for="comments">コメント:</label>
            <textarea id="comments" name="comments"></textarea>

            <button type="submit">登録</button>
        </form>
    </div>
</body>
</html>