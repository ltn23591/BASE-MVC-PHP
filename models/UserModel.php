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
}
