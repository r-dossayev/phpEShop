<?php

require_once 'models.php';
session_start();
try {
    $connection = new PDO("mysql:host=localhost;dbname=apple_shop;", "root", "");
} catch (Exception $e) {
    echo "<h4 style='color:red';>" . $e->getMessage() . "</h4>";
}
if (!function_exists('getCategoryItems')) {
    function getCategoryItems($id)
    {
        global $connection;
        $query = $connection->prepare("SELECT * FROM products WHERE category_id = $id");
        $query->execute();
        $result = $query->fetchAll();
        if ($result == null)
            return null;

        $products = [];
        foreach ($result as $item) {
            $products[] = new Product($item['id'], $item['name'], $item['selling_price'], $item['description'], $item['date'], $item['count'], $item['marked_price'], $item['category_id']);
        }
        return $products;
    }
}

if (!function_exists('getCategories')) {
    function getCategories()
    {
        global $connection;
        $query = $connection->prepare("SELECT * FROM category");
        $query->execute();
        $result = $query->fetchAll();
        if ($result == null)
            return null;

        $categories = [];
        foreach ($result as $item) {
            $categories[] = new Category($item['id'], $item['name']);
        }

        return $categories;
    }
}
if (!function_exists('searchProducts')) {
    function searchProducts($key)
    {
        global $connection;
        $query = $connection->prepare("SELECT * FROM products WHERE name LIKE '%" . $key . "%' OR description LIKE '%" . $key . "%'");
        $query->execute();
        $result = $query->fetchAll();
        if ($result == null)
            return null;

        $products = [];
        foreach ($result as $item) {
            $products[] = new Product($item['id'], $item['name'], $item['selling_price'], $item['description'], $item['date'], $item['count'], $item['marked_price'], $item['category_id']);
        }
        return $products;
    }
}
    if (!function_exists('getAllItems')) {
        function getAllItems()
        {
            global $connection;
            $query = $connection->prepare("SELECT * FROM products");
            $query->execute();
            $result = $query->fetchAll();
            if ($result == null)
                return null;

            $products = [];
            foreach ($result as $item) {
                $products[] = new Product($item['id'], $item['name'], $item['selling_price'], $item['description'], $item['date'], $item['count'], $item['marked_price'], $item['category_id']);
            }
            return $products;
        }
    }


if (!function_exists('getProduct')) {
    function getProduct($id)
    {
        global $connection;
        $query = $connection->prepare("SELECT * FROM products WHERE id = $id");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result == null)
            return null;
        return new Product($result['id'], $result['name'], $result['selling_price'], $result['description'], $result['date'], $result['count'], $result['marked_price'], $result['category_id']);
    }
}

if (!function_exists('getCategory')) {
    function getCategory($id)
    {
        global $connection;
        $query = $connection->prepare("SELECT * FROM category WHERE id = $id");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result == null)
            return null;
        return new Category($result['id'], $result['name']);
    }
}
if (!function_exists('getAuthUser')) {
    function getAuthUser()
    {
        global $connection;
        if (!isset($_SESSION['user_id'])) {
            return null;
        }
        $query = $connection->prepare("SELECT * FROM users WHERE id = " . $_SESSION['user_id']);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return null;
        }

        $result = new User($result['id'], $result['username'], $result['name'], $result['password'], $result['last_name'], $result['role'], $result['balance'], $result['last_login']);
//        print_r($result);
        return $result;
    }
}

class User
{
    public $id;
    public $username;
    public $name;
    public $password;
    public $last_name;
    public $role;
    public $balance;
    public $last_login;


    public function __construct($id, $username, $name, $password, $last_name, $role, $balance, $last_login)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->last_name = $last_name;
        $this->role = $role;
        $this->balance = $balance;
        $this->last_login = $last_login;
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
if (!function_exists('checkUser')) {
    function checkUser($username, $password)
    {
        global $connection;
        try {
            $query = $connection->prepare("
            SELECT * FROM users WHERE username = :username and password = :password
        ");
            $query->execute(["username" => $username, "password" => $password]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
        return $result;
    }
}
if (!function_exists('addUser')) {
    function addUser($name, $last_name, $username, $password)
    {
        global $connection;
        $role = 'USER';
        $query = $connection->prepare("
            INSERT INTO users (name, last_name, username, password, role)
            VALUES (:name, :last_name, :username, :password, :role)
        ");
        try {
            $query->execute(["name" => $name, "last_name" => $last_name, "username" => $username, "password" => $password, "role" => $role]);
        } catch (PDOException $e) {
            return false;
        }

        return true;
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

