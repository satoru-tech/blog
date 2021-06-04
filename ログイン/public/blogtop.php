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


// ブログ作る
function getAllBlog(){
    $dbh=connect();
    //1sqlの準備
    $sql='SELECT * FROM blogs ORDER BY id DESC';
    //2SQLの実行
    $stmt=$dbh->query($sql);
    //3SQLの結果を受け取る
    $result=$stmt->fetchall(PDO::FETCH_ASSOC);
    return $result;
    $dbh = null;
}
function checked($user_id, $blog_id){
    $dbh=connect();
    $blog_id=(int)$blog_id;
    $user_id=(int)$user_id;
    $sql="SELECT * FROM likes WHERE user = {$user_id} AND blog={$blog_id}";
    $stmt=$dbh->query($sql);
    $result=$stmt->fetchAll();

    if(!empty($result)){
        return "checked";
    } else{
        return "";
    }

}


$blogs=getAllBlog();

// コメント取得
function getComments($blog_id){
    $dbh=connect();
    $sql = "SELECT * FROM comments WHERE blog_id= {$blog_id}";
    $stmt=$dbh->query($sql);
    $result=$stmt->fetchAll();
    return $result;
}
function getUserName($user_id){
    $dbh=connect();
    $sql = "SELECT name FROM users WHERE id={$user_id}";
    $stmt=$dbh->query($sql);
    $result=$stmt->fetchColumn();
    return $result;
}


?>




<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../sass/style.css?<?php echo date('Ymd-Hi');?>">

    <title>ブログ一覧</title>
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
<section>
<h2 class="header">ブログ一覧</h2>
<a href="blogform.php" class="btn blog">ブログ投稿</a>
<div class="blog_container">
    <?php foreach($blogs as $blog): ?>
    <div class="blog_card">
        <h3><?php echo $blog['title'];?></h3>
        <div><img src="<?php echo setImage($blog['postImg']);?>" alt=""></div>
        <div class="blog_inside">
        <p><?php echo $blog['content']?></p>
        <p><?php echo $blog['datetime']?></p>
        <div class="personal">
        <p><?php echo $blog['postname']?></p>
        <a id="likeBtn" class="btn <?php echo checked($login_user['id'],$blog['id']);?>" href="like.php?type=article&id=<?php echo $blog['id']?>">いいね</a>
        <p id="count">いいね数 <?php  echo $blog['likes']?></p>
        <?php foreach(getComments($blog['id']) as $comment):?>
        <div class="comments">
            <p><?php echo $comment['content'];?></p>
            <p><?php echo getUserName($comment['user_id']);?></p>
            <p><?php echo $comment['datetime'];?></p>
        </div>
        <?php endforeach;?>
        <div class="commentWrite">
        <button id="commentBtn<?php echo $blog['id'];?>" >コメントを書く</button>
        </div>
        <div id="commentModal<?php echo $blog['id'];?>" class="commentModal">
            <form action="commentCreate.php" method="post">
                <label for="commentText">コメント</label>
                <input type="text" name="content">
                <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
                <input type="hidden" name="user_id" value="<?php echo $login_user['id']; ?>">
                <input type="hidden" name="datetime" value="<?php echo date('Y-m-d H:i:s'); ?>">
                <input type="submit" value="送信" class="btn">
            </form>
        </div>
        
        </div>
        </div>
    </div>
        <?php endforeach;?>
</div>
</section>
<script type="text/javascript" >
<?php foreach($blogs as $blog):?>
    let commentBtn<?php echo $blog['id']; ?>=document.getElementById("commentBtn<?php echo $blog['id'];?>");
    let commentModal<?php echo $blog['id']; ?>=document.getElementById("commentModal<?php echo $blog['id'];?>");
    commentBtn<?php echo $blog['id'];?>.addEventListener("click",()=>{
        commentModal<?php echo $blog['id']?>.classList.add('is_active');
    })

<?php endforeach;?>
</script>
        
</body>
</html>



