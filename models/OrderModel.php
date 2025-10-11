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
        $sql = "SELECT * FROM `" . self::TABLE . "` WHERE `user_id` = $userId ORDER BY id DESC";
        return $this->getByQuery($sql);
    }
    public function store($data)
    {
        $this->create(self::TABLE, $data);
        return mysqli_insert_id($this->conn); // trả về id của đơn hàng vừa tạo
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

    public function getTotalRevenue($expression, $condition)
    {
        return $this->sum(self::TABLE, $expression, $condition);
    }

    /**
     * Lấy tổng doanh thu của các đơn hàng đã giao, nhóm theo tháng.
     * @return array
     */
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

    /**
     * Lấy tổng doanh thu, nhóm theo từng trạng thái đơn hàng.
     * @return array
     */
    public function getRevenueByStatus()
    {
        $sql = "SELECT status, SUM(amount) AS total_revenue FROM " . self::TABLE . " GROUP BY status";
        return $this->getByQuery($sql);
    }
}