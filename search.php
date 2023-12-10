<!doctype html>
<html lang="en">
<?php include_once 'head.php'; ?>
<body>
<?php include_once 'navbar.php';
if (isset($_GET['keyword'])) {
    $key = $_GET['keyword'];
    $keyword = $key;
    $products = searchProducts($key);
} else {
    $products =null;
    $keyword = 'empty';
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Результаты по поиску : <span class="text-info">"<?= $keyword ?>"</span></h3>
            <hr>
            <?php
            require_once 'db.php';
            if ($products != null)
                foreach ($products as $item) {
                    ?>
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ result.image.url }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-md-9">
                            <h4><a href="{{ result.get_absolute_url }}"><?= $item->name ?></a></h4>
                            <p><?= $item->description ?></p>

                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>
