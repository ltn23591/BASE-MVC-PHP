<?php

class CartModel extends BaseModel
{
    const TABLE = 'order_items';
    public function getCart()
    {
        session_start();
        return $_SESSION['cart'] ?? [];
    }
    public function insert($data)
    {
        $this->create(self::TABLE, $data);
    }
}
