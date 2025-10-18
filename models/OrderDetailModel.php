<?php
class OrderDetailModel extends BaseModel
{
    const TABLE = 'order_items';

    //  Hàm lấy toàn bộ sản phẩm theo order_id
    public function getByOrderId($orderId)
    {
        $orderId = (int)$orderId; 
        $sql = "
            SELECT 
                order_items.*, 
                products.name, 
                products.image
            FROM order_items 
            JOIN products ON order_items.product_id = products.id
            WHERE order_items.order_id = $orderId
        ";

        return $this->getByQuery($sql); 
    }
    public function store($data)
    {
        $this->create(self::TABLE, $data);
    }
}