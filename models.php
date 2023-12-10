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

    public function __construct($id, $name, $selling_price, $description, $date, $count, $marked_price, $category_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->selling_price = $selling_price;
        $this->description = $description;
        $this->date = $date;
        $this->count = $count;
        $this->marked_price = $marked_price;
        $this->category_id = $category_id;
    }
}