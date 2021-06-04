<?php
  require_once '../dbconnect.php';

  class UserLogic
  {
      /**
       * ユーザーを登録する
       * @param array $userDate
       * @return bool $result
       */
      public static function createUser($userDate)
      {
        $result =false;
        $sql ='INSERT INTO users (name,email,
        password,team) VALUES (?,?,?,?)';

       //ユーザーデータ
        $arr = [];
        $arr[]= $userDate['username'];
        $arr[]= $userDate['email'];
        $arr[]= password_hash($userDate['password'],PASSWORD_DEFAULT);
        $arr[]= $userDate['team'];


        try{
            $stmt = connect()->prepare($sql); 
            $result = $stmt->execute($arr);
           return $result;

        } catch(\Exception $e){
           return $result;
        }

      }
      /**
       *
       * @param string $email
       * @param string $password
       * @return bool $result
       */
      public static function login($email,$password)
      {
        //   結果
        $result = false;
        // ユーザーをemailから検出して取得
        $user = self::getUserByEmail($email);
        if(!$user){
          $_SESSION['msg'] = 'emailが一致しません';
          return $result;
      }
      
      //パスワードの照会
      if(password_verify($password, $user['password'])){
          //ログイン成功
          session_regenerate_id(true);
          $_SESSION['login_user']= $user;
          $result = true;
          return $result;
      }
      
      $_SESSION['msg'] = 'パスワードが一致しません';
      return $result;
          

    



      }
      /**
       *emailからユーザーを取得
       * @param string $email
       * @return array |bool $user|$result
       */
      public static function getUserByEmail($email)
      {
        //SQLの準備
        //SQLの実行
        //SQLの結果を返す
        $sql = 'SELECT * FROM users WHERE email = ?' ;
        //emailを配列に入れる
      
        $arr = [];
        $arr[]= $email;
        

        try{
            $stmt = connect()->prepare($sql); 
            $stmt->execute($arr);
            //SQLの結果を返す
            $user = $stmt->fetch();
            return $user;

        } catch(\Exception $e){
            return false;
        }
      }
      /**
       *ログインチェック
       * @param void
       * @return bool $result
       */
      public static function checkLogin()
      {
        $result = false;
       //セッションにログインユーザーが入っていなかったらfalse
      if(isset($_SESSION['login_user']) &&  $_SESSION['login_user']['id']>0){
         return $result= true;
       }
        return $result;
      }

      /**
       * ログアウト処理
       */
      public static function logout()
      {
        $_SESSION = array();
        session_destroy();
      }
   

  }
  //  ブログ一覧作る
      // ブログ取り出す

?>