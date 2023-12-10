<?php

require_once 'models.php';
session_start();
try {
    $connection = new PDO("mysql:host=localhost;dbname=apple_shop;", "root", "");
} catch (Exception $e) {
    echo "<h4 style='color:red';>" . $e->getMessage() . "</h4>";
}
if (!function_exists('getUserCartItems')) {
    function getUserCartItems()
    {
        $user_id = getAuthUser()->id;
        if ($user_id == null)
            return null;
        global $connection;
        $query = $connection->prepare("SELECT * FROM cart WHERE user_id = $user_id AND status = 'PENDING'");
        $query->execute();
        $result = $query->fetchAll();
        if ($result == null)
            return null;

        $cartItems = [];
        foreach ($result as $item) {
            $cartItems[] = new Cart($item['id'], $item['user_id'], $item['product_id'], $item['count']);
        }
        return $cartItems;
    }
}

if (!function_exists('getUsers')) {
    function getUsers()
    {
        global $connection;
        $auth_user = getAuthUser();
        $query = $connection->prepare("SELECT * FROM users WHERE id != $auth_user->id");
        $query->execute();
        $result = $query->fetchAll();
        if ($result == null)
            return null;

        $users = [];
        foreach ($result as $item) {
            $users[] = new User($item['id'], $item['username'], $item['name'], $item['password'], $item['last_name'], $item['role'], $item['balance'], $item['last_login']);
        }
        return $users;
    }
}
if (!function_exists('getBuyingUserCartItems')) {
    function getBuyingUserCartItems()
    {
        $user_id = getAuthUser()->id;
        if ($user_id == null)
            return null;
        global $connection;
        $query = $connection->prepare("SELECT * FROM cart WHERE user_id = $user_id AND status = 'BOUGHT'");
        $query->execute();
        $result = $query->fetchAll();
        if ($result == null)
            return null;

        $cartItems = [];
        foreach ($result as $item) {
            $cartItems[] = new Cart($item['id'], $item['user_id'], $item['product_id'], $item['count']);
        }
        return $cartItems;
    }
}
if (!function_exists('addToCart')) {
    function addToCart($product_id, $count = 1)
    {
        $user_id = getAuthUser()->id;
        global $connection;
        $query = $connection->prepare("INSERT INTO cart (user_id, product_id, count) VALUES (?,?,?)");
        $query->execute([$user_id, $product_id, $count]);
        return true;
    }
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
            $products[] = new Product($item['id'], $item['name'], $item['selling_price'], $item['description'], $item['date'], $item['count'], $item['marked_price'], $item['category_id'], $item['image']);
        }
        return $products;
    }
}
if (!function_exists('addProduct')) {
    function addProduct($name, $selling_price, $description, $count, $marked_price, $category_id, $image)
    {
        global $connection;
        try {
            $query = $connection->prepare("INSERT INTO products (name, selling_price, description,count, marked_price, category_id, image) VALUES (?,?,?,?,?,?,?)");
            $query->execute([$name, $selling_price, $description, $count, $marked_price, $category_id, $image]);
            return true;
        } catch (Exception $e) {
            return false;
        }

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
            $products[] = new Product($item['id'], $item['name'], $item['selling_price'], $item['description'], $item['date'], $item['count'], $item['marked_price'], $item['category_id'], $item['image']);
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
            $products[] = new Product($item['id'], $item['name'], $item['selling_price'], $item['description'], $item['date'], $item['count'], $item['marked_price'], $item['category_id'], $item['image']);
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
        return new Product($result['id'], $result['name'], $result['selling_price'], $result['description'], $result['date'], $result['count'], $result['marked_price'], $result['category_id'], $result['image']);
    }
}
if (!function_exists('deleteProduct')) {
    function deleteProduct($id)
    {
        global $connection;
        $query = $connection->prepare("DELETE FROM products WHERE id = '$id'");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return true;
    }
}

if (!function_exists('updateProduct')) {
    //$goodsId, $updatedName, $sellPrice, $markPrice, $category, $description, $targetFile)
    function updateProduct($product_id, $name, $selling_price, $marked_price, $category_id, $description, $image = null)
    {
        global $connection;
        if ($image == null) {
            $query = $connection->prepare("UPDATE products SET name = ?, selling_price = ?, marked_price = ?, category_id = ?, description = ? WHERE id = ?");
            $query->execute([$name, $selling_price, $marked_price, $category_id, $description, $product_id]);

        } else {
            $query = $connection->prepare("UPDATE products SET name = ?, selling_price = ?, marked_price = ?, category_id = ?, description = ?, image = ? WHERE id = ?");
            $query->execute([$name, $selling_price, $marked_price, $category_id, $description, $image, $product_id]);
        }
        return true;
    }
}

if (!function_exists('incCart')) {
    function incCart($product_id)
    {
        global $connection;
        $query = $connection->prepare("UPDATE cart SET count = count + 1 WHERE product_id = $product_id AND user_id = " . getAuthUser()->id);
        $query->execute();
        return true;
    }
}
if (!function_exists('buyAllProducts')) {
    function buyAllProducts()
    {
        global $connection;
        $query = $connection->prepare("UPDATE cart SET status = 'BOUGHT' WHERE user_id = " . getAuthUser()->id);
        $query->execute();
        return true;
    }
}
if (!function_exists('dcrCart')) {
    function dcrCart($product_id)
    {
        global $connection;
        if (getCartCount($product_id) == 1)
            return rmvCart($product_id);
        $query = $connection->prepare("UPDATE cart SET count = count - 1 WHERE product_id = $product_id AND user_id = " . getAuthUser()->id);
        $query->execute();
        return true;
    }

}
if (!function_exists('updateBalance')) {
    function updateBalance($balance)
    {
        global $connection;
        $query = $connection->prepare("UPDATE users SET balance = $balance WHERE id = " . getAuthUser()->id);
        $query->execute();
        return true;
    }
}
if (!function_exists('updateRole')) {
    function updateRole($id, $role)
    {
        global $connection;
        $query = $connection->prepare("UPDATE users SET role = '$role' WHERE id = '$id'");
        $query->execute();
        return true;

    }
}

if (!function_exists('getCartCount')) {
    function getCartCount($product_id)
    {
        global $connection;
        $query = $connection->prepare("SELECT * FROM cart WHERE product_id = $product_id AND user_id = " . getAuthUser()->id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result == null)
            return 0;
        return $result['count'];
    }
}
if (!function_exists('rmvCart')) {
    function rmvCart($product_id)
    {
        global $connection;
        $query = $connection->prepare("DELETE FROM cart WHERE product_id = $product_id AND user_id = " . getAuthUser()->id);
        $query->execute();
        return true;
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

if (!function_exists('checkByUsername')) {
    function checkByUsername($username)
    {
        global $connection;
        $query = $connection->prepare("SELECT * FROM users WHERE username = '$username'");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
      $res = false;
        if ($result != null) {
            $res = true;
        }
        return $res;

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



