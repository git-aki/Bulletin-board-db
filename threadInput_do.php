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
if(empty($_POST['thread_name'])){
  echo "入力されていません。";
  echo "<P><a href='threadIndex.php'>スレッド一覧へ戻る</a></P>";
  exit();
} else {
  $thread_name = htmlspecialchars($_POST['thread_name']);
}


$sql = "SELECT * FROM `thread` WHERE thread_name = ?;";
require("dbconnect.php");
$connect = new Connect();
$existence_check = $connect->fetch_fun($sql,$thread_name);

if(isset($existence_check['thread_name'])){
  echo "既に存在しています。\n別の名前で再度作成し直してください。";
  echo "<P><a href='threadIndex.php'>スレッド一覧へ戻る</a></P>";
  exit();
} else {
  $sql = "INSERT INTO `thread` (`thread_id`, `thread_name`) VALUES (NULL, ?);";
  $connect = new Connect();
  $connect->bind_1($sql,$thread_name);
  mkdir("./image/".$thread_name, 0777);
  echo $thread_name."を作成しました。";      
}
?>
<P><a href="threadIndex.php">スレッド一覧へ戻る</a></P>
</body>    
</html>