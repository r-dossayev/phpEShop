<?php
    require_once("db.php");
    if($_SERVER['REQUEST_METHOD']==='POST'){
        if(isset($_POST['username']) && isset($_POST['password'])){
            $user = checkUser($_POST['username'], md5($_POST['password']));
            if($user!=null){
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header('location:index.php?login_success');
            }
            else header('location:login.php?error');
        }
    }
?>