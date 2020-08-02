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

$id = $_POST['id'];
$sql = "SELECT * FROM `list` WHERE id = ?;";
$list = $connect->fetch_fun($sql,$id);
?>
  <h2>編集</h2>
  <form action="update_do.php?thread_id=<?php echo urlencode($thread['thread_id']); ?>" method="post" enctype="multipart/form-data">
    <input type="text" name="author" placeholder="<?php echo $list['author']; ?>" value="<?php echo $list['author']; ?>">
    <br>
    <textarea name="content" cols="50" rows="10" placeholder="<?php echo $list['content']; ?>"  value="<?php echo $lists['content']; ?>"></textarea>
    <br>
    <p>画像投稿</p>
    <input type="file" name="image">
    <br>
    <button type="submit" name="id" value="<?php echo $id; ?>">投稿する</button>
  </form>
  <p><a href="index.php?thread_id=<?php echo urlencode($thread['thread_id']); ?>">スレッド<?php echo $thread['thread_name']; ?>へ戻る</a></P>
</body>    
</html>