<?php
require_once '../dbconnect.php';

class BlogLogic
{
   


    public static function createBlog($blogDate)
    {
    
    $sql ='INSERT INTO blogs (title,content,
    postname,postImg,datetime) VALUES (?,?,?,?,?)';

    $arr = [];
    $arr[]= $blogDate['title'];
    $arr[]= $blogDate['content'];
    $arr[]= $blogDate['postname'];
    $arr[]= $blogDate['postImg'];
    $arr[]= $blogDate['datetime'];

    try{
        $stmt = connect()->prepare($sql); 
        $stmt->execute($arr);
    } catch(\Exception $e){
        exit($e);
    }

    }



}


?>