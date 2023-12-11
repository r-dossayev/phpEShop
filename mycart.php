<!doctype html>
<html lang="en">
<?php include_once 'head.php'; ?>
<body>
<?php include_once 'navbar.php';
if (getAuthUser() == null) {
    header('Location:login.php');
}
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'inc' && isset($_GET['product_id'])) {
        $res = incCart($_GET['product_id']);
        if (!$res)  header('Location:index.php?error');
    } else if ($_GET['action'] === 'dcr') {
        $res = dcrCart($_GET['product_id']);
        if (!$res)  header('Location:index.php?error');
    } else if ($_GET['action'] === 'rmv') {
        $res = rmvCart($_GET['product_id']);
        if (!$res)  header('Location:index.php?error');
    }
}
if (isset($_POST['total_summa'])) {
    $total_summa = $_POST['total_summa'];
    $user_balance = getAuthUser()->balance;
    if ($total_summa > $user_balance) {
        $_SESSION['errors'] = ['У вас недостаточно средств для покупки'];
    } else {
       $res = buyAllProducts();
        if (!$res)  header('Location:index.php?error');
        else {
            $_SESSION['success'] = ['Товары успешно куплены'];
        }

    }

}
if (isset($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
    unset($_SESSION['errors']);
}
if (isset($_SESSION['success'])) {
    foreach ($_SESSION['success'] as $success) {
        echo "<div class='alert alert-success'>$success</div>";
    }
    unset($_SESSION['success']);
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h4>Товары в корзине</h4>
            <hr>
            <table class="table">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Товар</th>
                    <th>Количество</th>
                    <th>Стоимость</th>
                    <th>Изменить</th>
                </tr>
                </thead>
                <tbody>
                <?php
                require_once 'db.php';
                $total_summa = 0;
                $products = getUserCartItems();
                if ($products != null && count($products) > 0)
                foreach ($products as $item) {
                    $total_summa += $item->getTotal();
                    ?>
                    <tr>
                        <td><?= $item->id ?></td>
                        <td><a href="show.php?item=<?= $item->getProduct()->id ?>"><?= $item->getProduct()->name ?></a>
                        </td>
                        <td><?= $item->count ?> штук</td>
                        <td><?= $item->getProduct()->selling_price ?> тг</td>
                        <td>
                            <a href="mycart.php?action=inc&product_id=<?= $item->getProduct()->id ?>"
                               class="btn btn-primary">+</a>
                            <a href="mycart.php?action=dcr&product_id=<?= $item->getProduct()->id ?>"
                               class="btn btn-warning">- </a>
                            <a href="mycart.php?action=rmv&product_id=<?= $item->getProduct()->id ?>"
                               class="btn btn-danger">x </a>
                        </td>
                    </tr>

                    <?php
                }
                ?>

                <tr>
                    <th colspan="4" class="text-right">Общий сумма</th>
                    <th><?= $total_summa ?> тг</th>
                </tr>

                </tbody>
            </table>
            <form method="post">
                <input type="hidden" name="total_summa" value="<?= $total_summa ?>">
                <button class="btn btn-info"> Купить все товары</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
