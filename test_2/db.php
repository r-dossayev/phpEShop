<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "site";

try {
    $connection = new PDO("mysql:host=localhost;dbname=apple_shop;", "root", "");
} catch (Exception $e) {
    echo "<h4 style='color:red';>" . $e->getMessage() . "</h4>";
}

if (!function_exists('getCategories')) {
    function getCategories()
    {
        global $connection;
        $query = $connection->prepare("SELECT * FROM category");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    if (!function_exists('getAllItems')) {
        function getAllItems()
        {
            global $connection;
            $query = $connection->prepare("SELECT * FROM products");
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
    }
}

if (!function_exists('getUserFromSession')) {

    function getUserFromSession()
    {
        // Проверяем, существует ли ключ 'user_id' в сессии
        if (isset($_SESSION['user_id'])) {
            // Если существует, то получаем данные пользователя из БД
            $userId = $_SESSION['user_id'];

            global $conn;

            $sql = "SELECT * FROM users WHERE id = $userId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                return $user;
            }
        }

        return null;
    }
}


if (!function_exists('getCategories')) {
    function createGoods($name, $price, $image, $user)
    {
        global $conn;

        $sql = "INSERT INTO goods (name, price, image, user_id) VALUES ('$name', $price, '$image', '$user')";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            // Выводим сообщение об ошибке
            echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
    }
}
// Проверяем, определена ли функция searchGoods
if (!function_exists('searchGoods')) {
    // Определение функции searchGoods
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
}


if (!function_exists('readGoods')) {
    function readGoods($category = null)
    {
        global $conn;
        $goods = array();

        $whereCondition = $category ? "WHERE category_id = $category" : "";
        $sql = "SELECT * FROM goods $whereCondition";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $goods[] = $row;
            }
        }

        return $goods;
    }
}


if (!function_exists('getGoodCategory')) {
    function getGoodCategory($id)
    {
        global $conn;

        $sql = "SELECT * FROM categories WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc();
            return $category;
        }

        return null;
    }
}


if (!function_exists('banUser')) {
    function banUser($id)
    {
        global $conn;

        $sql = "UPDATE users SET banned = 1 WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
    }
}

if (!function_exists("unbanUser")) {
    function unbanUser($id)
    {
        global $conn;

        $sql = "UPDATE users SET banned = 0 WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
    }
}

if (!function_exists('updateRole')) {
    function updateRole($id, $role)
    {
        global $conn;

        $sql = "UPDATE users SET role = '$role' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
    }
}

if (!function_exists('deleteCategory')) {
    function deleteCategory($id)
    {
        global $conn;

        $sql = "DELETE FROM categories WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
    }
}

if (!function_exists('addCategory')) {
    function addCategory($name)
    {
        global $conn;

        $sql = "INSERT INTO categories (name) VALUES ('$name')";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
    }
}


if (!function_exists('updateGood')) {
    function updateGood($id, $name, $price, $category)
    {
        global $conn;

        $sql = "UPDATE goods SET name = '$name', price = $price, category_id = $category WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
    }
}

if (!function_exists('deleteGood')) {
    function deleteGood($id)
    {
        global $conn;

        $sql = "DELETE FROM goods WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
    }
}