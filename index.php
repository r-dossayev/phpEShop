<!doctype html>
<html lang="en">
<?php include_once 'head.php'; ?>
<body>
<?php include_once 'navbar.php';

if (isset($_GET['category_id'])) {
    $id = $_GET['category_id'];
    $products = getCategoryItems($id);
} else {
    $products = getAllItems();
}
?>
<div class="container">

    <?php if (isset($_GET['delete'])) { ?>
        <div class="alert alert-success" role="alert">
            Товар успешно удален!
        </div>
    <?php } ?>
    <h1 class="text-center">Добро пожаловать наш сайт </h1>
    <hr>
    <div class="row mt-4" style="margin-left: 150px">
        <?php
        require_once 'db.php';
        if ($products != null)
        foreach ($products as $item) {
            ?>
            <div class="col-md-3 card" style="margin-left: 30px">
                <div class="m-3">
                    <h4><a href="show.php?item=<?= $item->id ?>"><?= $item->name ?></a></h4>
                    <p class="card-text"><?= substr_replace($item->description, "...", 80) ?></p>

                    <img src="<?= $item->image ?>"
                         alt="" class="img-fluid"
                         style="height: 200px; object-fit: contain;">
                    <p class="mt-3">Цена: <strike>старый. <?= $item->marked_price ?>тг</strike>
                        текущий. <?= $item->selling_price ?>тг</p>
                    <?php
                    if (getAuthUser() != null) {
                        ?>
                        <center>

                            <form action="add_to_cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?= $item->id ?>">
                                <button class="btn btn-info">в корзину</button>
                            </form>
                        </center>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>



</div>
</body>
</html>
