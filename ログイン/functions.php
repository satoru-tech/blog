<?php

/**
 *XSS対策：エスケープ処理 
 *
 * @param string $str 対象の文字列
 * @return string 処理された文字列
 */


 function h($str){
     return htmlspecialchars($str, ENT_QUOTES,'UTF-8');
 }

 /**
  * CSRF対策
  */
  function setToken(){
      //トークンを作成
      //フォームからそのトークンを送信
      //送信後の画面でそのトークンを照会
      //トークンを削除
     
      $csrf_token = bin2hex(random_bytes(32));
      $_SESSION['csrf_token']= $csrf_token;

      return $csrf_token;
  }
  function setImage($i){
    switch($i){
        case 1:
            echo "../img/img1.jpg";
            break;
        case 2:
            echo "../img/img2.png";
            break;
        case 3:
            echo "../img/img3.png";
            break;
        }
    } 
    function setName($i){
        switch($i){
          case 1:
            echo "北海道";
            break;
          case 2:
            echo "富山県";
            break;
          case 3:
            echo "石川県";
            break;
        }
      }
?>