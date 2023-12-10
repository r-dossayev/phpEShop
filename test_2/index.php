<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if(isset($_GET['login_success'])){
    echo "<div class='alert alert-success'>Вы успешно вошли в систему</div>";
}


$sqlCategories = "SELECT * FROM categories";
$resultCategories = $conn->query($sqlCategories);

$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;

$goodsList = readGoods($selectedCategory);
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>

<body>
    <?php include 'navbar.php'; ?>







    <!-- <div class="container">
        <h2>Goods List</h2>

        <form action="index.php" method="get">
            <label for="category">Choose a category:</label>
            <select name="category">
                <option value="">All Categories</option>
                <?php while ($category = $resultCategories->fetch_assoc()): ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $selectedCategory) ? 'selected' : ''; ?>><?php echo $category['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <input type="submit" value="Filter">
        </form>

        </div> -->


    <?php include 'footer.php' ?>
</body>

</html>
