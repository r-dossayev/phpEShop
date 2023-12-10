

<?php
require_once 'db.php';
require_once 'models.php';
if (isset($_GET['category_id'])) {
    $id = $_GET['category_id'];
    $products = getCategoryItems($id);
} else {
    $products = getAllItems();
}
