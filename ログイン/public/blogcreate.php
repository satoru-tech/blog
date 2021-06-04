<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../classes/BlogLogic.php';
require_once '../functions.php';
//ログインしているか判定し、していなかったら新規登録画面へ帰す
$result = UserLogic::checkLogin();

if(!$result){
    $_SESSION['login_err']='ユーザーを登録してログインしてください';
    header('Location: signup_form.php');
    return;
}
$login_user = $_SESSION['login_user'];

$hasCreated = BlogLogic::createBlog($_POST);

header('Location:blogtop.php');


?>



