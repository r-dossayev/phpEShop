<?php
include('db.php');

if (isset($_POST['create'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Handle file upload
    $targetDirectory = "uploads/";

    // Создаем уникальную директорию для каждого товара
    $uniqueDirectory = uniqid('goods_', true);
    $targetDirectory .= $uniqueDirectory . '/';

    // Создаем директорию, если её еще нет
    if (!is_dir($targetDirectory)) {
        mkdir($targetDirectory, 0755, true);
    }

    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

    // Переименовываем файл, чтобы он был уникальным внутри директории
    $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $uniqueFileName = uniqid('image_', true) . '.' . $extension;
    $targetFile = $targetDirectory . $uniqueFileName;

    // Move the uploaded file to the target directory without extensive checks
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Call the createGoods function with the file path
        if (createGoods($name, $price, $targetFile)) {
            echo "Goods added successfully!";
            header("Location: index.php");
        } else {
            echo "Error adding goods: " . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

