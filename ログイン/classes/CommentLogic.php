<?php
require_once '../dbconnect.php';
class CommentLogic
{
    public static function createComment($commentDate)
    {
        $sql ="INSERT INTO comments (content,blog_id,
        user_id,datetime) VALUES (?,?,?,?)";
        $arr = [];
        $arr[]= $commentDate['content'];
        $arr[]= $commentDate['blog_id'];
        $arr[]= $commentDate['user_id'];
        $arr[]= $commentDate['datetime'];

        try{
            $stmt = connect()->prepare($sql); 
            $stmt->execute($arr);
        } catch(\Exception $e){
            exit($e);
        
        }
    }


}














?>