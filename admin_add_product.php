<!doctype html>
<html lang="en">
<?php include_once 'head.php'; ?>
<body>
<?php include_once 'navbar.php';
//if (getAuthUser() == null || getAuthUser()->role !== 'admin') {
//    header("Location: index.php");
//    exit;
//}

// Обработка формы при отправке
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['name'];
    $categoryID = $_POST['category'];
    $sellingPrice = $_POST['selling_price'];
    $markedPrice = $_POST['marked_price'];
    $description = $_POST['description'];
    $count = $_POST['count'];
    // Ваши проверки и обработка данных

    // Обработка загрузки изображения
    $targetDirectory = "uploads/";

    $uniqueDirectory = uniqid('item_', true);
    $targetDirectory .= $uniqueDirectory . '/';

    if (!is_dir($targetDirectory)) {
        mkdir($targetDirectory, 0755, true);
    }

    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

    $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $uniqueFileName = uniqid('image_', true) . '.' . $extension;
    $targetFile = $targetDirectory . $uniqueFileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        //    function addProduct($name, $selling_price, $description, $count, $marked_price, $category_id, $image)
        $res = addProduct($productName ,$sellingPrice, $description, $count, $markedPrice, $categoryID, $targetFile);
        if ($res) {
            echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
            exit;
        } else {
            echo "<div class='alert alert-danger'>Error: " . 'error' . "<br>" . 'error' . "</div>";
        }
    } else {
        header('Location:index.php');
    }
}
?>
<div class="container">
    <div class="mt-4">
        <h2>Добавить товар</h2>
    </div>
    <!-- Форма добавления товара с выбором категории -->
    <form class="col-sm-6" action="admin_add_product.php" method="post" enctype="multipart/form-data">
        <div class="mt-2">
            <label for="name">Name:</label>
            <input class="form-control" type="text" name="name" required><br>
        </div>

        <div class="mt-2">
            <label for="price">Selling Price:</label>
            <input class="form-control" type="number" name="selling_price" step="0.01" required><br>
        </div>

        <div class="mt-2">
            <label for="price">Marked Price:</label>
            <input class="form-control" type="number" name="marked_price" step="0.01" required><br>
        </div>
        <div class="mt-2">
            <label for="price">Count:</label>
            <input class="form-control" type="number" name="count" step="0.01" required><br>
        </div>
        <div class="mt-2">
            <label for="price">description:</label>
            <textarea class="form-control" name="description" required></textarea>
        </div>
        <div class="mt-2">
            <label for="category">Category:</label>
            <select class="form-control" name="category" required>
                <?php
                require_once 'db.php';
                $cats = getCategories();
                foreach ($cats as $cat) {
                    ?>
                    <option value="<?= $cat->id; ?>"><?= $cat->name; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>

        <div class="mt-2">
            <label for="image">Image:</label>
            <input class="form-control" type="file" name="image" accept="image/*" required><br>
        </div>

        <div class="mt-2">
            <button class="btn btn-primary">Добавить</button>
        </div>
    </form>
</div>
</body>
</html>



