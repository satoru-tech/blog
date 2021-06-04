<?php
session_start();
require_once '../classes/UserLogic.php';
$result = UserLogic::checkLogin();

if(!$result){
    $_SESSION['login_err']='ユーザーを登録してログインしてください';
    header('Location: signup_form.php');
    return;
}
$login_user = $_SESSION['login_user'];



// いいね作る
function createLike($login_id,$blog_id){
    $dbh=connect();
    $sql="INSERT INTO likes (user,blog
    ) VALUE ({$login_id},{$blog_id})";
    $dbh->query($sql);
}

function likeCount($blog_id){
    $blog_id=(int)$blog_id;
    $dbh=connect();
    $sql="UPDATE blogs SET likes=likes+1 WHERE id= {$blog_id}";
    $dbh->query($sql);

}


function likeCheck($login_id,$blog_id){
    $dbh=connect();
    $sql="SELECT blog FROM likes WHERE user = {$login_id}";
    $stmt=$dbh->query($sql);
    $result=$stmt->fetchAll(PDO::FETCH_COLUMN);

    if(!in_array($blog_id,$result)){
        createLike($login_id,$blog_id);
        likeCount($blog_id);
    }
    
}


if(isset($_GET['type'],$_GET['id'])){
    $type = $_GET['type'];
    $id = (int)$_GET['id'];
    switch($type){
        case 'article':
            likeCheck((int)$login_user['id'],$id);
        
    
        break;
    }
}
// いいねカウント

header('Location: blogtop.php');


?>