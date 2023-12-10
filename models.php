<?php


class Category
{
    public $id;
    public $name;

//    public $image;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}

class Product
{
    public $id;
    public $name;
    public $selling_price;
    public $description;
    public $date;
    public $count;
    public $marked_price;
    public $category_id;
    public $image;

    public function __construct($id, $name, $selling_price, $description, $date, $count, $marked_price, $category_id, $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->selling_price = $selling_price;
        $this->description = $description;
        $this->date = $date;
        $this->count = $count;
        $this->marked_price = $marked_price;
        $this->category_id = $category_id;
        $this->image = $image;
    }


    public function getCategory()
    {
        return getCategory($this->category_id);
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
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->last_name = $last_name;
        $this->role = $role;
        $this->balance = $balance;
        $this->last_login = $last_login;
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }
}


class Cart{
    public $id;
    public $user_id;
    public $product_id;
    public $count;
//    public $date;

    public function __construct($id, $user_id, $product_id, $count)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->count = $count;
//        $this->date = $date;
    }

    public function getProduct()
    {
        return getProduct($this->product_id);
    }

//    public function getUser()
//    {
//        return getUser($this->user_id);
//    }
    public function getTotal()
    {
        return $this->count * $this->getProduct()->selling_price;
    }

}