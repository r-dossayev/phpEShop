<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['last_name']) && isset($_POST['password'])) {
        if (checkByUsername($_POST['username'])) {
            $_SESSION['errors'] = ['Пользователь с таким логином уже существует',];
            header('Location:registration.php?error_username');
            exit;
        }
        if ($_POST['password'] === $_POST['confirm_password']) {
            $uppercase = preg_match('@[A-Z]@', $_POST['password']);
            $lowercase = preg_match('@[a-z]@', $_POST['password']);
            $number    = preg_match('@[0-9]@', $_POST['password']);
            if(!$uppercase || !$lowercase || !$number || strlen($_POST['password']) < 8) {
                $_SESSION['errors'] = ['Пароль должен содержать не менее 8 символов, как минимум одну заглавную букву, одну строчную букву и одну цифру',];
                header('Location:registration.php?error_password');
                exit;
            }
            if (addUser($_POST['name'], $_POST['last_name'], $_POST['username'], md5($_POST['password']))) {
                header('Location:login.php?reg_success');
            } else header('Location:registration.php?error');
        } else
        {
            $_SESSION['errors'] = ['Пароли не совпадают',];
            header('Location:registration.php?error_password');
        }
    }
}
?>