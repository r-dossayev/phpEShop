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
$price_to =999999999;
if (isset($_GET['price_to']) && $_GET['price_to'] != '') {
    $price_to = $_GET['price_to'];
}
$price_from = 0;
if (isset($_GET['price_from']) && $_GET['price_from'] != '') {
    $price_from = $_GET['price_from'];
}

$sort_type ='asc';
if(isset($_GET['sort_type'])){
    $sorting_type = 'name';
    if($_GET['sort_type'] == 'price_asc'){
        $sorting_type = 'selling_price';
        $sort_type = 'asc';
    }else if($_GET['sort_type'] == 'price_desc'){
        $sorting_type = 'selling_price';
        $sort_type = 'desc';
    }else if($_GET['sort_type'] == 'name_asc'){
        $sorting_type = 'name';
        $sort_type = 'asc';
    }else if($_GET['sort_type'] == 'name_desc'){
        $sorting_type = 'name';
        $sort_type = 'desc';
    }
    $products = filterProducts($price_from, $price_to, $sort_type, $sorting_type);
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
