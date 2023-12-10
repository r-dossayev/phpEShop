<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Проверка роли пользователя
if ($_SESSION['role'] != 'admin') {
    // Если пользователь не администратор, перенаправить его на главную страницу
    header("Location: index.php");
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

if (isset($_GET['delete'])) {
    $deleteSql = "DELETE FROM goods WHERE id = $goodsId";

    if ($conn->query($deleteSql) === TRUE) {
        echo "Goods deleted successfully!";
    } else {
        echo "Error deleting goods: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h2> Goods өшіру</h2>

    <p>Бауырым точна өшіресіңба?</p>

    <div class="card" style="width: 18rem;">
        <img src="<?php echo $goodsItem['image']; ?>" class="card-img-top" alt="Goods Image">
        <div class="card-body">
            <h5 class="card-title"><?php echo $goodsItem['name']; ?></h5>
            <p class="card-text">Price: $<?php echo $goodsItem['price']; ?></p>
        </div>
    </div>

    
    <a href="delete.php?id=<?php echo $goodsItem['id']; ?>&delete=1" class="btn btn-danger">Иә</a>
    <a href="index.php" class="btn btn-secondary">Жоқ</a>

</div>

</body>
</html>
