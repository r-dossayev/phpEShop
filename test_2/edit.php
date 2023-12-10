<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Проверка роли пользователя
if ($_SESSION['role'] != 'admin') {
    // Если пользователь не администратор, перенаправить его на главную страницу
    header("Location: index.phpe");
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $goodsId = $_POST["goods_id"]; // Assuming you have a hidden input field for goods_id in your form

    $updatedName = $_POST["updated_name"];
    $updatedPrice = $_POST["updated_price"];

    // Обработка загрузки изображения (если было изменено)
    $targetDirectory = "uploads/";

    // Проверяем, было ли отправлено новое изображение
    if ($_FILES["updated_image"]["size"] > 0) {
        // Создаем уникальный каталог
        $uniqueDirectory = uniqid('goods_', true);
        $targetDirectory .= $uniqueDirectory . '/';

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        // Генерируем уникальное имя файла
        $extension = pathinfo($_FILES["updated_image"]["name"], PATHINFO_EXTENSION);
        $uniqueFileName = uniqid('image_', true) . '.' . $extension;
        $targetFile = $targetDirectory . $uniqueFileName;

        // Перемещаем загруженный файл в новый каталог
        if (move_uploaded_file($_FILES["updated_image"]["tmp_name"], $targetFile)) {
            // Используем новый путь к изображению при обновлении
            $updateSql = "UPDATE goods SET name='$updatedName', price=$updatedPrice, image='$targetFile' WHERE id=$goodsId";
        } else {
            echo "<div class='alert alert-danger'>Sorry, there was an error uploading the updated file.</div>";
            exit;
        }
    } else {
        // Используем существующий путь к изображению при обновлении без изменения файла
        $updateSql = "UPDATE goods SET name='$updatedName', price=$updatedPrice WHERE id=$goodsId";
    }

    // Выполняем SQL-запрос для обновления товара в базе данных
    if ($conn->query($updateSql) === TRUE) {
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
        <h2>Edit Goods</h2>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="goods_id" value="<?php echo $goodsItem['id']; ?>">
            <div class="mt-2">
            <label for="updated_name">Name:</label>
            <input class="form-control" type="text" name="updated_name" value="<?php echo $goodsItem['name']; ?>" required><br>
            </div>

            <div class="mt-2">
            <label for="updated_price">Price:</label>
            <input class="form-control" type="number" name="updated_price" value="<?php echo $goodsItem['price']; ?>" step="0.01" required><br>

            </div>
            <div class="mt-2">
            <label for="updated_image">Image URL:</label>
            <input class="form-control" type="file" name="updated_image">
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Изменить</button>
            </div>
        </form>
    </div>

</body>
</html>
