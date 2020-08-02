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

$sql = "SELECT `id` FROM `list` ORDER BY `id` DESC LIMIT 1;";
$connect = new Connect();
$resurt = $connect->query_fun($sql);
$max_id = $resurt->fetch(PDO::FETCH_ASSOC);
if($max_id){
  $id = $max_id['id']+1;
}

if(empty($_POST['author'])){
  $author = "名無し";
} else{
  $author = htmlspecialchars($_POST['author']);
}

if(empty($_POST['content'])){
  $content = null;
} else {
  $content = htmlspecialchars($_POST['content']);
}

if(!empty($_FILES['image']['name'])){
  require("image.php");
} else {
  $image = null;
}

$sql = "INSERT INTO `list` (`id`, `author`, `content`, `image`, `time`, `updatetime`, `thread_id`) VALUES (NULL, ?, ?, ?, current_timestamp(), NULL, ?);";
$connect = new Connect();
$connect->bind_4($sql,$author,$content,$image,$thread_id);
  echo "投稿しました。";
?>
<P><a href="index.php?thread_id=<?php echo urlencode($thread['thread_id']); ?>">スレッド<?php echo $thread['thread_name']; ?>へ戻る</a></P>
</body>    
</html>