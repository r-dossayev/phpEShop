<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['last_name']) && isset($_POST['password'])) {
        if ($_POST['password'] === $_POST['confirm_password']) {
            if (addUser($_POST['name'], $_POST['last_name'], $_POST['username'], md5($_POST['password']))) {
                header('Location:login.php?reg_success');
            } else header('Location:registration.php?error');
        } else header('Location:registration.php?error_password');
    }
}
?>