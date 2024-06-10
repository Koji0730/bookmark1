<?php

//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続関数：db_conn()
function db_conn(){
    try {
        //さくらインターネット用
        // $db_name = "merumimi_bookmark1";    //データベース名
        // $db_id = "merumimi";
        // $db_pw   = "a1-111111"; 
        // $db_host = "mysql57.merumimi.sakura.ne.jp";

        //ローカル接続用
        $db_name = "bookmark_db";
        $db_id   = "root";      //アカウント名
        $db_pw   = "";          //パスワード：XAMPPはパスワード無し or MAMPはパスワード”root”に修正してください。
        $db_host = "localhost"; //DBホスト

        return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }
}


//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

//リダイレクト関数: redirect($file_name)
function redirect($file_name){
    header("Location: ".$file_name);
    exit();
}

//SessionCheck(スケルトン)
function sschk(){
    if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
        exit("Login Error");
    }else{
        session_regenerate_id(true); 
        $_SESSION["chk_ssid"] = session_id();
    }
  }

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function register_user($username, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $file = fopen('users.txt', 'a');
    fwrite($file, $username . "," . $hashed_password . "\n");
    fclose($file);
}

function user_exists($username) {
    $users = file('users.txt', FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list($existing_username, ) = explode(",", $user);
        if ($existing_username == $username) {
            return true;
        }
    }
    return false;
}

function login_user($username, $password) {
    $users = file('users.txt', FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list($existing_username, $hashed_password) = explode(",", $user);
        if ($existing_username == $username && password_verify($password, $hashed_password)) {
            return true;
        }
    }
    return false;
}
?>

