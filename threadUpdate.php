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
?>

<form action="threadUpdate_do.php?thread_id=<?php echo urlencode($thread_id); ?>" method="post">
  <textarea name="update" cols="50" rows="1" placeholder="新しいスレッド名を入力してください" value=""></textarea><br>
  <button type="submit">変更する</button>
</form>
<P><a href="threadIndex.php">スレッド一覧へ戻る</a></P>
</body>    
</html>