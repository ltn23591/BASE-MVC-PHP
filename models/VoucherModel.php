<?php
class VoucherModel extends BaseModel
{
    const TABLE = 'discount';

    // Lấy tất cả voucher
    public function getAll($select = ['*'], $orderBys = [], $limit = 15)
    {
        return $this->all(self::TABLE, $select, $orderBys, $limit);
    }

    // Tìm voucher theo id
    public function findById($id)
    {
        return $this->findById(self::TABLE, $id);
    }

    // Thêm voucher mới
    public function createVoucher($data)
    {
        $this->create(self::TABLE, $data);
    }

    // Cập nhật thông tin voucher
    public function updateVoucher($id, $data)
    {
        $this->update(self::TABLE, $id, $data);
    }

    // Xóa voucher
    public function deleteVoucher($id)
    {
        $this->delete(self::TABLE, $id);
    }
}