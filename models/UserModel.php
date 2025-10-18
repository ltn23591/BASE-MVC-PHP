<?php

class UserModel extends BaseModel
{
    const TABLE = 'users';

    // Lấy tất cả user
    public function getAll($select = ['*'])
    {
        return $this->all(self::TABLE, $select);
    }

    // Tìm user theo id
    public function findById($id)
    {
        return $this->find(self::TABLE, $id);
    }

    // Tìm user theo email
    public function findByEmail($email)
    {
        return $this->findEmail(self::TABLE, $email);
    }

    // Thêm user mới (đăng ký)
    public function store($data)
    {

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->create(self::TABLE, $data);
    }

    // Cập nhật thông tin user
    public function updateData($id, $data)
    {
        $this->update(self::TABLE, $id, $data);
    }

    // Xóa user
    public function destroy($id)
    {
        $this->delete(self::TABLE, $id);
    }

    // Tài khoản bị khóa
    public function lockAccount($id)
    {
        // Cập nhật trạng thái thành 'locked'
        $this->updateData($id, ['status' => 'locked']);
    }


    public function unlockAccount($id)
    {
        // Cập nhật trạng thái thành 'active'
        $this->updateData($id, ['status' => 'active']);
    }

    // TotalSpent
    public function totalSpent($userId, $amount)
    {
        $sql = "UPDATE users 
            SET total_spent = total_spent + $amount 
            WHERE id = $userId";
        $this->_query($sql);

        // Gọi hàm cập nhật rank sau khi cộng
        $this->updateRank($userId);
    }

    public function updateRank($userId)
    {
        $sql = "SELECT total_spent FROM users WHERE id = $userId";
        $result = $this->_query($sql);
        $row = mysqli_fetch_assoc($result);
        $total = $row['total_spent'];

        $rank = 'Đồng';
        if ($total >= 1000000 && $total < 2000000) {
            $rank = 'Bạc';
        } elseif ($total >= 2000000 && $total < 3000000) {
            $rank = 'Vàng';
        } elseif ($total >= 3000000) {
            $rank = 'Kim Cương';
        }

        $sqlUpdate = "UPDATE users SET rank = '$rank' WHERE id = $userId";
        $this->_query($sqlUpdate);
    }
}
