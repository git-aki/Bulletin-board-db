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
<div>
  <?php
if(!is_numeric($_GET['thread_id'])){
  echo "数字以外のidが送信されました。もう一度やり直してください。";
  echo "<P><a href='threadIndex.php'>スレッド一覧へ戻る</a></P>";
  exit();
} else {
  $thread_id = $_GET['thread_id'];
}
  ?>
<h2>検索・並び替え</h2>
<form action="index.php?thread_id=<?php echo urlencode($thread_id); ?>" method="post" enctype="multipart/form-data">
  <input type="text" name="keyword" placeholder="キーワードを入力">
  <button type="submit" name="search">検索</button>
  <?php if(isset($_POST['search']) && ($_POST['keyword'] === "")){ echo "キーワードが未入力です。"; } ?>
  <p>投稿日順<input type="radio" name="sort" value="ASC" checked="checked">昇順
  <input type="radio" name="sort" value="DESC">降順
  <button type="submit" name="sort_button">並び替え</button></p>
  <button type="submit" name="reset">元に戻す</button>
</form>
</div>
<?php
require("dbconnect.php");

if(isset($_POST['search']) && ($_POST['keyword'] !== "")) {
  $keyword = htmlspecialchars($_POST['keyword']);
  $sql = "SELECT * FROM `list` WHERE thread_id = ? AND `author` LIKE ? ORDER BY `time` ASC;";
  $keyword = '%'.$keyword.'%';
  $connect = new Connect();
  $lists = $connect->fetchall_fun_bind2($sql,$thread_id,$keyword);
}elseif(isset($_POST['sort_button']) && $_POST['sort'] === "DESC"){
  $sql = "SELECT * FROM `list` WHERE `thread_id` = ? ORDER BY `time` DESC;";
  $connect = new Connect();
  $lists = $connect->fetchall_fun($sql,$thread_id);
} else {
  $sql = "SELECT * FROM `list` WHERE `thread_id` = ? ORDER BY `time` ASC;";  
  $connect = new Connect();
  $lists = $connect->fetchall_fun($sql,$thread_id);
}

echo "<h2>投稿内容</h2>";
foreach ($lists as $list):
?>
<main>
  <br>
  <?php  echo $list['author']."&nbsp;".$list['content']."&nbsp;".$list['time']."&nbsp;";if(!is_null($list['updatetime'])){ echo $list['updatetime']; } ?>
  <form action="update.php?thread_id=<?php echo urlencode($thread_id); ?>" method="post" style="display: inline"><button type="submit" name="id" value="<?php echo $list['id']; ?>">編集</button></form>
  <form action="delete.php?thread_id=<?php echo urlencode($thread_id); ?>" method="post" style="display: inline"><button type="submit" name="id" value="<?php echo $list['id']; ?>">消去</button></form>
  <br>
  <?php if(!is_null($list['image'])){ echo "<img src=".$list['image'].">"; } ?>
  <br>
  </main>
<?php 
  endforeach;
?>


<h2>投稿</h2>
<form action="input_do.php?thread_id=<?php echo urlencode($thread_id); ?>" method="post" enctype="multipart/form-data">
  <input type="text" name="author" placeholder="名無し">
  <br>
  <textarea name="content" cols="50" rows="10" placeholder="投稿内容" value=""></textarea>
  <br>
  <p>画像投稿</p>
  <input type="file" name="image">
  <br>
  <button type="submit">投稿する</button>
</form>

<P><a href="threadIndex.php">スレッド一覧へ戻る</a></P>
</body>    
</html>