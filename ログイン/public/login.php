<?php
session_start();
ini_set('display_errors', true);
require_once '../classes/UserLogic.php';


// エラーメッセージ
$err =[];

// バリデーション

if(!$email = filter_input(INPUT_POST,'email')){
    $err['email'] = 'メールアドレスを記入してください';
};
if(!$password = filter_input(INPUT_POST,'password')){
    $err['password']= 'パスワードを入力してください';
};




if(count($err) > 0){
    // エラーがあった場合戻す
    $_SESSION = $err;
   header('Location: login_form.php');
   return;

};

$result = UserLogic::login($email,$password);

if(!$result){
    header('Location: login_form.php');
    return;
};


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../sass/style.css?<?php echo date('Ymd-Hi');?>">

    <title>ログイン完了</title>
</head>
<body>
<section class="popup">

<h2>ログイン完了</h2>
    <p>ログインしました</p>
   
    <a href="./mypage.php">マイページへ</a>
</section>
</body>
</html>