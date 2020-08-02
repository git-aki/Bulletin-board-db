<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="./style.css">
<title>掲示板</title>
</head>
<body>
<header>
  <h1>掲示板</h1>
</header>
<main>
<h2>スレッド一覧</h2>
<?php

$sql = "SELECT * FROM `thread`;";
require('dbconnect.php');
$connect = new Connect();
$resurt = $connect->query_fun($sql);
$threads = $resurt->fetchall(PDO::FETCH_ASSOC);
foreach ($threads as $thread):
  ?>
    <form action="index.php" method="get" style="display: inline">
      <a href="./index.php?thread_id=<?php echo urlencode($thread['thread_id']); ?>">
       ・<?php echo $thread['thread_name']; ?>
      </a>
    </form>
    &nbsp;
    <form action="threadUpdate.php" method="get" style="display: inline"><button type="submit" name="thread_id" value="<?php echo $thread['thread_id']; ?>">名前変更</button></form>
    <form action="threadDelete.php"method="get" style="display: inline"><button type="submit" name="thread_id" value="<?php echo $thread['thread_id']; ?>">消去</button></form>
    <br>
  <?php endforeach; ?>
</main>
  <h2>スレッド作成</h2>
<form action="threadInput_do.php" method="post">
  <textarea name="thread_name" cols="50" rows="1" placeholder="スレッド名を入力してください" value=""></textarea>
  <button type="submit" style="display: inline">作成する</button>
</form>
</body>    
</html>