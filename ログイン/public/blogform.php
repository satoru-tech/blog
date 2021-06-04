<?php
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../sass/style.css?<?php echo date('Ymd-Hi');?>">
    <title>ブログ投稿</title>
</head>
<body>
<header>
<div class="header_right">
    <div class="personal">
    <p><?php echo h($login_user['name'])?></p>
    <div><img src="<?php setImage($login_user['team']) ?>" alt=""></div>
    </div>
</div>
</header>
<form action="blogcreate.php" method="post">
    <label for="title">タイトル<input type="text" name="title"></label> 
    <label for="content" class="text">内容<input type="text" name="content" class=""></label> 
    <input type="hidden" name="postname" value="<?php echo $login_user['name'] ?>">
    <input type="hidden" name="postImg" value="<?php echo $login_user['team']?>">
    <input type="hidden" name="datetime" value="<?php echo date('Y-m-d H:i:s')?>"> 
    
    <input type="submit" class="btn">
</form>
<script type="text/javascript" src="../js.php"></script>
</body>

</html>
