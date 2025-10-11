<?php
class RatingModel extends BaseModel
{
    const TABLE = 'ratings';

    public function getAll($select = ['*'])
    {
        return $this->all(self::TABLE, $select);
    }
    public function findById($id)
    {
        return $this->find(self::TABLE, $id);
    }

    public function store($data)
    {
        return $this->create(self::TABLE, $data);
    }

    //Lấy id đánh giá của người dùng
    public function getAllRatings($productId)
    {
        $sql = "SELECT u.id,r.rating,r.comment,r.created_at,u.name 
        FROM ratings r join users u on r.user_id = u.id 
        WHERE product_id = $productId";
        return $this->getByQuery($sql);
    }
    // Tổng số đánh giá
    public function totalRatings($productId)
    {
        $sql = "SELECT COUNT(*) AS total_reviews 
                FROM ratings 
                WHERE product_id = $productId";
        return $this->getByQuery($sql);
    }
    // Trung bình đánh giá
    public function averageRatings($productId)
    {
        $sql = "SELECT AVG(rating) AS avg_rating FROM ratings WHERE product_id = $productId";
        return $this->getByQuery($sql);
    }

    public function getByProductId($productId)
    {
        $productId = (int)$productId;
        $sql = "SELECT r.*, u.name as user_name 
                FROM " . self::TABLE . " r
                JOIN users u ON r.user_id = u.id
                WHERE r.product_id = {$productId}
                ORDER BY r.created_at DESC";
        return $this->getByQuery($sql);
    }
}
