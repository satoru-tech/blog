<?php

session_start();
ini_set('display_errors', true);
require_once '../classes/UserLogic.php';

// エラーメッセージ
$err =[];

$token = filter_input(INPUT_POST,'csrf_token');
//トークンがない、もしくは一致しない場合処理
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    exit('不正なリクエストです');
}

unset($_SESSION['csrf_token']);

// バリデーション
if(!$username = filter_input(INPUT_POST,'username')){
    $err[] = 'ユーザー名を記入してください';
};
if(!$username = filter_input(INPUT_POST,'email')){
    $err[] = 'メールアドレスを記入してください';
};
$password = filter_input(INPUT_POST,'password');

// 正規表現
if(!preg_match("/\A[a-z\d]{8,100}+\z/i",$password)){
    $err[]='パスワードを英数字8文字以上100時以下にしてください';
}
$password_conf = filter_input(INPUT_POST,'password_conf');
if($password !== $password_conf){
    $err[]='確認パスワードと異なっています';
}

if(count($err) === 0){
    // ユーザーを確認する処理
    $hasCreated = UserLogic::createUser($_POST);
    if(!$hasCreated){
        $err[]= '登録に失敗しました';
    }

}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録完了画面</title>
</head>
<body>
<?php if(count($err)>0):?>
 <?php foreach($err as $e):?>
   <p><?php echo $e;?> </p>
   <?php endforeach?>
 <?php else: ?>
    <p>ユーザー登録完了</p>
  <?php endif ?>  
    <a href="./signup_form.php">戻る</a>
</body>
</html>