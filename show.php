<!doctype html>
<html lang="en">
<?php include_once 'head.php'; ?>
<body>
<?php include_once 'navbar.php';
if (isset($_GET['item'])) {
    $id = $_GET['item'];
    $product = getProduct($id);
    if ($product == null) {
        header("Location: index.php");
    }
}
?>
<div class="container">
    <h3><?=$product->name ?></h3><hr>
    <div class="row">
        <div class="col-md-4">
            <img src="<?=$product->image ?>" alt="" class="img-fluid">
        </div>
        <div class="col-md-8">
            <h4><?=$product->name ?> (осталось <?=$product->count ?> )</h4>
            <h5>Kатегория: <?=$product->getCategory()->name ?></h5>

            <h5>Цена: старый: <strike><?=$product->marked_price ?>тг</strike> текущий: <?=$product->selling_price ?>тг</h5>
            <?php if (getAuthUser() != null && getAuthUser()->role == 'USER' ) { ?>
                <form method="post" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?=$product->id ?>">
                    <button class="btn btn-info">в корзину</button>
                </form>

            <?php } ?>
            <?php if (getAuthUser() != null && getAuthUser()->role == 'ADMIN') { ?>
            <a href="update_product.php?item=<?=$product->id ?>" class="btn btn-warning">Редактировать</a>
            <a href="delete_product.php?item=<?=$product->id ?>" class="btn btn-danger">Удалить</a>

            <?php } ?>
            <hr>
            <p><?=$product->description ?></p>
        </div>
    </div>

</div>
</body>
</html>


