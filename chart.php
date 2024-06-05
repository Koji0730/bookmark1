<?php
// エラー表示
ini_set("display_errors", 1);
error_reporting(E_ALL);
include("funcs.php");

// 1.  DB接続します
$pdo = db_conn();

// 2. データ登録SQL作成
$sql = "SELECT genre, rating FROM bookmark_an_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// 3. データ表示
if ($status == false) {
    // execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:" . $error[2]);
}

// 全データ取得
$values = $stmt->fetchAll(PDO::FETCH_ASSOC); // PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
if ($values === false) {
    exit("FETCH_ERROR: Data could not be retrieved.");
}

// JSONエンコード
$json = json_encode($values, JSON_UNESCAPED_UNICODE);
if ($json === false) {
    exit("JSON_ERROR: " . json_last_error_msg());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>評価とジャンルのグラフ</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    div {padding: 10px; font-size: 16px;}
    canvas {max-width: 1200px; margin: auto; height: 600px;}
</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
    <nav class="navbar navbar-default">
    <div">
        <div>
            <a href="index.php">登録画面へ</a>
        </div>
        <div>
            <a href="select.php">全データ表示</a>
        </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div class="container jumbotron">
    <canvas id="ratingChart"></canvas>
</div>
<!-- Main[End] -->

<script>
  // PHPからJSONデータを取得
    const data = <?php echo $json; ?>;
    console.log(data); // デバッグ用: データをコンソールに表示

  // 固定のジャンルリスト（投稿がないジャンルも含む）
    const fixedGenres = ['fiction', 'nonfiction', 'mystery', 'science', 'history', 'philosophy'];

  // ジャンルごとの評価を集計する
  const genres = {};
  fixedGenres.forEach(genre => genres[genre] = []);
  
  data.forEach(item => {
    if (genres[item.genre] !== undefined) {
      genres[item.genre].push(parseFloat(item.rating));
    }
  });

  // 各ジャンルの平均点を計算する
  const labels = Object.keys(genres);
  const averages = labels.map(genre => {
    const ratings = genres[genre];
    const sum = ratings.reduce((a, b) => a + b, 0);
    return ratings.length ? (sum / ratings.length) : 0;
  });

  console.log('Genres:', genres); // デバッグ用: ジャンルごとのデータを表示
  console.log('Averages:', averages); // デバッグ用: 平均評価を表示

  // 最高評価を取得
  const maxAverage = Math.max(...averages);
  const maxIndex = averages.indexOf(maxAverage);

  // ジャンルごとの固定色リスト
  const colors = {
    'fiction': '#FF9999',
    'nonfiction': '#FFCC99',
    'mystery': '#FFFF99',
    'science': '#CCFF99',
    'history': '#99FFCC',
    'philosophy': '#99CCFF'
  };

  // Chart.jsでグラフを描画する
  const ctx = document.getElementById('ratingChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: '平均評価',
        data: averages,
        backgroundColor: labels.map((label, index) => index === maxIndex ? '#FFD700' : colors[label])
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          max: 10,
          title: {
            display: true,
            text: '平均評価'
          }
        },
        x: {
          title: {
            display: true,
            text: 'ジャンル'
          }
        }
      },
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          callbacks: {
            label: function(tooltipItem) {
              const isMax = tooltipItem.dataIndex === maxIndex;
              return `平均評価: ${tooltipItem.raw.toFixed(2)}${isMax ? ' ☆' : ''}`;
            }
          }
        }
      }
    }
  });
</script>

</body>
</html>
