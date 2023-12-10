<?php
// Явно включаем файл db.php
include_once 'db.php';



session_start();

// Функция поиска товаров по запросу и категории
function searchGoods($query, $category = null)
{
    global $conn;
    $goods = array();

    // Подготовка условия для поиска
    $whereCondition = "WHERE name LIKE '%$query%'";
    if ($category) {
        $whereCondition .= " AND category_id = $category";
    }

    // SQL-запрос
    $sql = "SELECT * FROM goods $whereCondition";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $goods[] = $row;
        }
    }

    return $goods;
}

// Проверяем, был ли запрос на поиск
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    $query = $_GET['query'];

    // Определяем текущую выбранную категорию (из параметров GET)
    $selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;

    // Выполняем поиск товаров с учетом категории
    $goodsList = searchGoods($query, $selectedCategory);

    // Сохраняем результат поиска в сессии
    $_SESSION['search_results'] = $goodsList;

    // Перенаправляем обратно на index.php с параметром поиска
    header("Location: index.php?query=$query&category=$selectedCategory");
    exit;
}
?>
