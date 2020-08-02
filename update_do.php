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

$sql = "SELECT * FROM `thread` WHERE `thread_id` = ?;";
$connect = new Connect();
$thread = $connect->fetch_fun($sql,$thread_id);

$id = $_POST['id'];

$sql = "SELECT * FROM `list` WHERE `id` = ?;";
$list = $connect->fetch_fun($sql,$id);

$author = htmlspecialchars($_POST['author']);
if(empty($author)){
  $author = "名無し";
}
  if(!empty($_POST['content'])){
    $content = htmlspecialchars($_POST['content']);
  } else{
    $content = $list['content'];
  }

  if(($_FILES['image']['size'] !== 0) && !is_null($list['image'])){
    unlink($list['image']);
    require("./image.php");
  } elseif(($_FILES['image']['size'] === 0) && !is_null($list['image'])){
    $image = $list['image'];
  } elseif(($_FILES['image']['size'] !== 0) && is_null($list['image'])){
    require("./image.php");
  } elseif(($_FILES['image']['size'] === 0) && is_null($list['image'])){
    $image = $list['image'];
  }

  $sql = "UPDATE `list` SET `author` = ?, `content` = ?, `image` = ?, `updatetime` = CURRENT_TIMESTAMP() WHERE `list`.`id` = ?;";
  $connect = new Connect();
  $connect->bind_4($sql,$author,$content,$image,$id);

echo "編集しました。";
?>
<P><a href="index.php?thread_id=<?php echo urlencode($thread['thread_id']); ?>">スレッド<?php echo $thread['thread_name']; ?>へ戻る</a></P>
</body>    
</html>