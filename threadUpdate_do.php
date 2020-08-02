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

if(empty($_POST['update'])){
  echo "入力されていません。";
  echo "<P><a href='threadIndex.php'>スレッド一覧へ戻る</a></P>";
  exit();
} else {
  $updatethread_name = htmlspecialchars($_POST['update']);
}

require("dbconnect.php");

$sql = "SELECT * FROM `thread` WHERE thread_id = ?;";
$connect = new Connect();
$thread = $connect->fetch_fun($sql,$thread_id);

$sql = "SELECT * FROM `thread` WHERE thread_name = ?;";
$existence_check = $connect->fetch_fun($sql,$updatethread_name);

if(isset($existence_check['thread_name'])){
  echo "既に存在しています。\n別の名前で再度変更し直してください。";
  echo "<P><a href='threadIndex.php'>スレッド一覧へ戻る</a></P>";
  exit();
} else {
  $sql = "UPDATE `thread` SET `thread_name` = ? WHERE `thread`.`thread_id` = ?";
  $connect = new Connect();
  $connect->bind_2($sql,$updatethread_name,$thread_id);

  rename("./image/".$thread['thread_name'],"./image/".$updatethread_name);
  echo $thread['thread_name']."を".$updatethread_name."に変更しました。";
}
?>
<P><a href="threadIndex.php">スレッド一覧へ戻る</a></P>
</body>    
</html>