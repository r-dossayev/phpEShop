<?php

require_once 'db.php';


if (isset($_GET['item'])) {
        $productId = $_GET['item'];
        $productItem = getProduct($productId);
        if ($productItem == null) {
            header("Location: index.php");
        }
        deleteProduct($productId);
        header("Location: index.php?delete=1");
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h2> Goods өшіру</h2>

    <p>Бауырым точна өшіресіңба?</p>

    <div class="card" style="width: 18rem;">
        <img src="<?php echo $goodsItem['image']; ?>" class="card-img-top" alt="Goods Image">
        <div class="card-body">
            <h5 class="card-title"><?php echo $goodsItem['name']; ?></h5>
            <p class="card-text">Price: $<?php echo $goodsItem['price']; ?></p>
        </div>
    </div>

    
    <a href="delete.php?id=<?php echo $goodsItem['id']; ?>&delete=1" class="btn btn-danger">Иә</a>
    <a href="index.php" class="btn btn-secondary">Жоқ</a>

</div>

</body>
</html>
