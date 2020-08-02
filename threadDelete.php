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

require("dbconnect.php");
$sql = "SELECT * FROM `thread` WHERE thread_id = ?;";
$connect = new Connect();
$thread = $connect->fetch_fun($sql,$thread_id);

$sql = "DELETE FROM `thread` WHERE `thread_id` = ?;";
$connect = new Connect();
$connect->bind_1($sql,$thread_id);

$sql = "DELETE FROM `list` WHERE `thread_id` = ?;";
$connect->bind_1($sql,$thread_id);


$images = glob("./image/".$thread['thread_name']."/*");
if($images){
  foreach($images as $image){
    unlink($image);
  }
}
rmdir('./image/'.$thread['thread_name']);
echo $thread['thread_name']."を消去しました。";
?>
<P><a href="threadIndex.php">スレッド一覧へ戻る</a></P>
</body>    
</html>