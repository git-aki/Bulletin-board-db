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
<?php

if(!is_numeric($_GET['thread_id'])){
  echo "数字以外のidが送信されました。もう一度やり直してください。";
  echo "<P><a href='threadIndex.php'>スレッド一覧へ戻る</a></P>";
  exit();
} else {
  $thread_id = $_GET['thread_id'];
}

$id = $_POST['id'];

require("dbconnect.php");
$sql = "SELECT * FROM `thread` WHERE thread_id = ?;";
$connect = new Connect();
$thread = $connect->fetch_fun($sql,$thread_id);

$sql = "SELECT `image` FROM `list` WHERE `id` = ?;";
$list = $connect->fetch_fun($sql,$id);

if(!empty($list['image'])){
  unlink($list['image']);
}

$sql = "DELETE FROM `list` WHERE `id` = ?;";
$connect = new Connect();
$connect->bind_1($sql,$id);

echo "削除しました。";
?>
<P><a href="index.php?thread_id=<?php echo urlencode($thread_id); ?>">スレッド<?php echo $thread['thread_name']; ?>へ戻る</a></P>
</body>    
</html>