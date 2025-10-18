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
        return $this->find(self::TABLE, $id);
    }

    // Thêm voucher mới
    public function createVoucher($data)
    {
        return $this->create(self::TABLE, $data);
    }

    // Cập nhật voucher
    public function updateVoucher($id, $data)
    {
        return $this->update(self::TABLE, $id, $data);
    }

    // Xóa voucher
    public function deleteVoucher($id)
    {
        return $this->delete(self::TABLE, $id);
    }

    // ✅ Tìm voucher theo code (dùng cho chức năng ÁP DỤNG MÃ GIẢM GIÁ)
    public function findByCode($code)
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE code = ? LIMIT 1";
        $result = $this->getByQuery($sql, [$code]);

        if (!empty($result)) {
            return $result[0];
        }

        return null;
    }
}
