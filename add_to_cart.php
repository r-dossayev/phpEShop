
<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id']) && getAuthUser() != null && getAuthUser()->role === 'USER') {
       $res = addToCart($_POST['product_id']);
       if ($res) header('Location:mycart.php');
       else header('Location:index.php?error');
    }
}
