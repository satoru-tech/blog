<?php

ini_set('display_errors', true);
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';
//ログインしているか判定し、していなかったら新規登録画面へ帰す
$result = UserLogic::checkLogin();

if(!$result){
    $_SESSION['login_err']='ユーザーを登録してログインしてください';
    header('Location: signup_form.php');
    return;
}
$login_user = $_SESSION['login_user'];


?>




<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../sass/style.css">
    <title>マイページ</title>
</head>
<body>
<h2>マイページ</h2>
  
    <p>ログインユーザー:<?php echo h($login_user['name'])?></p>
  <p>メールアドレス:<?php  echo h($login_user['email']) ?></p>  
  <p>チーム:<?php setName($login_user['team'])?></p>
  <img src="<?php setImage($login_user['team']) ?>" alt="">
  <form action="./logout.php" method="post">
  <input class="btn" type="submit" name="logout" value="ログアウト">
  </form>

  <a href="./blogtop.php" >ブログ一覧へ</a>
  <a href="./blogform.php">ブログ投稿へ</a>
</body>
</html>