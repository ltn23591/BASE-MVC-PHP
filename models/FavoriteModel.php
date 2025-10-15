<?php
class FavoriteModel extends BaseModel
{
    const TABLE = 'favorites';

    // Thêm vào danh sách yêu thích
    public function addFavorite($userId, $productId)
    {
        $sql = "INSERT INTO " . self::TABLE . " (user_id, product_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $userId, $productId);
        return mysqli_stmt_execute($stmt);
    }

    // Xóa khỏi danh sách yêu thích
    public function removeFavorite($userId, $productId)
    {
        $sql = "DELETE FROM " . self::TABLE . " WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $userId, $productId);
        return mysqli_stmt_execute($stmt);
    }

    // Kiểm tra sản phẩm đã yêu thích chưa
    public function isFavorite($userId, $productId)
    {
        $sql = "SELECT id FROM " . self::TABLE . " WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $userId, $productId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    // Lấy danh sách yêu thích của user
    public function getFavoritesByUser($userId)
    {
        $sql = "SELECT p.* 
                FROM products p
                JOIN " . self::TABLE . " f ON p.id = f.product_id
                WHERE f.user_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
}
