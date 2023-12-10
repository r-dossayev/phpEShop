<?php
include_once('db.php');


if (getAuthUser() == null && !getAuthUser()->isAdmin()) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['item'])) {
    $productId = $_GET['item'];
    $productItem = getProduct($productId);
    if ($productItem == null) {
        header("Location: index.php");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $goodsId = $_POST["product_id"]; // Assuming you have a hidden input field for goods_id in your form
    $updatedName = $_POST["name"];
    $sellPrice = $_POST["selling_price"];
    $markPrice = $_POST["marked_price"];
    $category = $_POST["category"];
    $description = $_POST["description"];

    $res = false;
    $targetDirectory = "uploads/";

    // Проверяем, было ли отправлено новое изображение
    if ($_FILES["updated_image"]["size"] > 0) {
        // Создаем уникальный каталог
        $uniqueDirectory = uniqid('goods_', true);
        $targetDirectory .= $uniqueDirectory . '/';

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        $extension = pathinfo($_FILES["updated_image"]["name"], PATHINFO_EXTENSION);
        $uniqueFileName = uniqid('image_', true) . '.' . $extension;
        $targetFile = $targetDirectory . $uniqueFileName;
        if (move_uploaded_file($_FILES["updated_image"]["tmp_name"], $targetFile)) {
         $res = updateProduct($goodsId, $updatedName, $sellPrice, $markPrice, $category, $description, $targetFile);
        } else {
            echo "<div class='alert alert-danger'>Sorry, there was an error uploading the updated file.</div>";
            exit;
        }
    } else {
     $res = updateProduct($goodsId, $updatedName, $sellPrice, $markPrice, $category, $description);
    }

    // Выполняем SQL-запрос для обновления товара в базе данных
    if ($res) {
        echo "<div class='alert alert-success'>Товар успешно отредактирован</div>";
    } else {
        echo "<div class='alert alert-danger'>Товар не был обновлен</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <?php include 'head.php'; ?>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Edit</h2>

        <form  method="post" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $productItem->id; ?>">
            <div class="mt-2">
            <label for="updated_name">Name:</label>
            <input class="form-control" type="text" name="name" value="<?php echo $productItem->name; ?>" required><br>
            </div>

            <div class="mt-2">
                <label for="price">Selling Price:</label>
                <input value="<?php echo $productItem->selling_price; ?>" class="form-control" type="number" name="selling_price" step="0.01" required><br>
            </div>

            <div class="mt-2">
                <label for="price">Marked Price:</label>
                <input value="<?php echo $productItem->marked_price; ?>" class="form-control" type="number" name="marked_price" step="0.01" required><br>
            </div>
            <div class="mt-2">
                <label for="price">Count:</label>
                <input value="<?php echo $productItem->count; ?>" class="form-control" type="number" name="count" step="0.01" required><br>
            </div>
            <div class="mt-2">
                <label for="price">description:</label>
                <textarea class="form-control" name="description" required><?php echo $productItem->description; ?></textarea>
            </div>
            <div class="mt-2">
                <label for="category">Category:</label>
                <select class="form-control" name="category" required>
                    <?php
                    require_once 'db.php';
                    $cats = getCategories();
                    foreach ($cats as $cat) {
                        ?>
                        <option  value="<?= $cat->id; ?>" <?= $cat->id == $productItem->category_id ? 'selected' : ''; ?>><?= $cat->name; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="mt-2">
                <label for="image">Image:</label> <img src="<?=$productItem->image?>" alt="" width="50" height="50">
                <input class="form-control" type="file" name="updated_image" accept="image/*" ><br>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Изменить</button>
            </div>
        </form>
    </div>

</body>
</html>
