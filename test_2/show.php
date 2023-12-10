<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $goodsId = $_GET['id'];

    $sql = "SELECT * FROM goods WHERE id = $goodsId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $goodsItem = $result->fetch_assoc();
    } else {
        echo "Goods not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

$sql = "SELECT * FROM categories WHERE id = " . $goodsItem['category_id'];

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $category = $result->fetch_assoc();
    $goodCategory = $category['name'];
} else {
    $goodCategory = 'No category';
}

// Проверяем, существует ли ключ 'user_role' в сессии
$userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;




if(isset($_POST['delete_post_btn'])){

    deleteGood($_POST['good_id']);

    header("Location: shop.php?good_deleted=true");

}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>

<body>
    <?php include 'navbar.php'; ?>
    
    <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?php echo $goodsItem['image']; ?>" alt="..." /></div>
                    <div class="col-md-6">
                        <div class="mb-1"><h5><?php echo $goodCategory ?></h5></div>
                        <h1 class="display-5 fw-bolder"><?php echo $goodsItem['name']; ?></h1>
                        <div class="fs-5 mb-5">
                            <span style="text-decoration: line-through" class="text-decoration-line-through">$<?php echo $goodsItem['price'] + 100 ?></span>
                            <span>$<?php echo $goodsItem['price']; ?></span>
                        </div>
                        <p class="lead"></p>
                        <?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'moderator' || $goodsItem['id'] == $_SESSION['user_id']): ?>
                        <div class="d-flex">
                            <a class="btn btn-outline-dark flex-shrink-0" href="edit.php?id=<?php echo $goodsItem['id'] ?>">Редактировать</a>
                        <form method="post" action="" style="margin-left: 10px;">
                        <input type="hidden" name="good_id" value="<?php echo $goodsItem['id'] ?>">
                            <button class="btn btn-outline-danger flex-shrink-0" name="delete_post_btn">
                                Удалить
                            </button>
                        </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

</body>

</html>
