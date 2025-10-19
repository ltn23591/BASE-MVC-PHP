<?php

class OrderModel extends BaseModel
{
    const TABLE = 'orders';

    public function getAll($select = ['*'], $orderBys = [], $limit = 15)
    {
        return $this->all(self::TABLE, $select, $orderBys, $limit);
    }

    public function getByUser($userId)
    {
        $userId = (int)$userId;
        $sql = "SELECT * FROM " . self::TABLE . " WHERE user_id = $userId ORDER BY id DESC";
        return $this->getByQuery($sql);
    }

    public function store($data)
    {
        $this->create(self::TABLE, $data);
        return mysqli_insert_id($this->conn);
    }

    public function findById($id)
    {
        return $this->find(self::TABLE, $id);
    }

    public function updateData($id, $data)
    {
        $this->update(self::TABLE, $id, $data);
    }

    public function destroy($id)
    {
        $this->delete(self::TABLE, $id);
    }

    /** ================== DOANH THU ================== */

    // Tổng doanh thu theo điều kiện
    public function getTotalRevenue($expression, $condition)
    {
        return $this->sum(self::TABLE, $expression, $condition);
    }

    // Doanh thu theo trạng thái
    public function getRevenueByStatus()
    {
        $sql = "SELECT status, SUM(amount) AS total_revenue 
                FROM " . self::TABLE . " 
                GROUP BY status";
        return $this->getByQuery($sql);
    }

    // Doanh thu theo tháng
    public function getMonthlyRevenue()
    {
        $sql = "SELECT 
                    YEAR(date) as year, 
                    MONTH(date) as month, 
                    SUM(amount) as total_revenue
                FROM " . self::TABLE . "
                WHERE status = 'Đã giao'
                GROUP BY YEAR(date), MONTH(date)
                ORDER BY year, month";
        return $this->getByQuery($sql);
    }

    // Doanh thu trong 1 ngày cụ thể
    public function getDayRevenue($day)
    {
        $day = $this->conn->real_escape_string($day);
        $sql = "SELECT SUM(amount) AS total_revenue 
                FROM " . self::TABLE . " 
                WHERE status = 'Đã giao' 
                AND DATE(date) = '{$day}'";
        $result = $this->getByQuery($sql);
        return (float)($result[0]['total_revenue'] ?? 0);
    }

    // Doanh thu từng ngày (cho biểu đồ)
    public function getDailyRevenue()
    {
        $sql = "SELECT 
                    DATE(date) AS order_date, 
                    SUM(amount) AS total_revenue
                FROM " . self::TABLE . " 
                WHERE status = 'Đã giao' 
                GROUP BY DATE(date)
                ORDER BY order_date ASC";
        return $this->getByQuery($sql);
    }

    /** ================== LIÊN QUAN ĐẾN ĐƠN HÀNG ================== */

    public function getRecentOrdersWithUserDetails(int $limit = 10)
    {
        $limit = (int)$limit;
        $sql = "SELECT o.*, u.name as user_name
                FROM " . self::TABLE . " o
                LEFT JOIN users u ON o.user_id = u.id
                ORDER BY o.id DESC
                LIMIT " . $limit;
        return $this->getByQuery($sql);
    }


    public function hasDeliveredProduct($userId, $productId)
    {
        $userId = (int)$userId;
        $productId = (int)$productId;

        $sql = "SELECT oi.id 
                FROM orders o
                JOIN order_items oi ON o.id = oi.order_id
                WHERE o.user_id = $userId
                AND o.status = 'Đã giao'
                AND oi.product_id = $productId
                LIMIT 1";
        $result = $this->getByQuery($sql);

        return !empty($result);
    }
}
