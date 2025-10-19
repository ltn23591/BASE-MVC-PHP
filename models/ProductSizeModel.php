<?php

class ProductSizeModel extends BaseModel
{
    const TABLE = 'product_sizes';

    public function getByProductId($id)
    {
        return $this->find(self::TABLE, $id);
    }

    public function store($data)
    {
        $this->create(self::TABLE, $data);
    }

    // Lấy tổng sổ lượng của một sản phẩm
    public function getTotalProduct($id)
    {
        $sql = "SELECT SUM(quantity) AS total
            FROM product_sizes ps 
            JOIN products p ON p.id = ps.product_id
            WHERE p.id = $id";
        return $this->getByQuery($sql);
    }

    // Lấy tổng sổ lượng của một sản phẩm theo size
    public function getTotalProductSize($id, $size)
    {
        $sql = "SELECT SUM(quantity) AS total
            FROM product_sizes ps 
            JOIN products p ON p.id = ps.product_id
            WHERE p.id = $id AND ps.size = '$size'";
        return $this->getByQuery($sql);
    }

    // Lấy danh sách size còn hàng của 1 sản phẩm
    public function getSizeByProductId($productId)
    {
        $productId = (int)$productId;
        $sql = "SELECT size, quantity 
            FROM " . self::TABLE . " 
            WHERE product_id = {$productId} AND quantity > 0";
        return $this->getByQuery($sql);
    }

    // ✅ Giảm tồn kho khi đặt hàng
    public function decreaseStock($productId, $size, $quantityToDecrease)
    {
        $productId = (int)$productId;
        $quantityToDecrease = (int)$quantityToDecrease;
        $sizeEsc = mysqli_real_escape_string($this->conn, $size);

        $sql = "UPDATE product_sizes
                SET quantity = quantity - {$quantityToDecrease}
                WHERE product_id = {$productId} 
                AND size = '{$sizeEsc}' 
                AND quantity >= {$quantityToDecrease}";
        return $this->_query($sql);
    }

    // ✅ Cộng lại tồn kho khi hủy đơn hàng
    public function increaseStock($productId, $size, $quantity)
    {
        $productId = (int)$productId;
        $quantity = (int)$quantity;
        $sizeEsc = mysqli_real_escape_string($this->conn, $size);

        $sql = "UPDATE product_sizes 
                SET quantity = quantity + {$quantity}
                WHERE product_id = {$productId} AND size = '{$sizeEsc}'";
        return $this->_query($sql);
    }
}