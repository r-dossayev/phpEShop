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
            <img src="data:image/jpeg;base64,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" alt="" class="img-fluid">
        </div>
        <div class="col-md-8">
            <h4><?=$product->name ?> (осталось <?=$product->count ?> )</h4>
            <h5>Kатегория: <?=$product->getCategory()->name ?></h5>

            <h5>Цена: старый: <strike><?=$product->marked_price ?>тг</strike> текущий: <?=$product->selling_price ?>тг</h5>
            <?php if (getAuthUser() != null) { ?>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?=$product->id ?>">
                    <button href="#" class="btn btn-info">в корзину</button>
                </form>
            <?php } ?>
            <hr>
            <p><?=$product->description ?></p>
        </div>
    </div>

</div>
</body>
</html>


