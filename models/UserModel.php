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
        // $sql = "SELECT * FROM " . self::TABLE . " WHERE email = '" . $email . "' LIMIT 1";
        // $query = $this->_query($sql);

        // return mysqli_fetch_assoc($query); // ✅ trả về mảng thay vì chuỗi
        return $this->findEmail(self::TABLE, $email);
    }

    // Thêm user mới (đăng ký)
    public function store($data)
    {
        // Mã hóa mật khẩu trước khi lưu
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
}