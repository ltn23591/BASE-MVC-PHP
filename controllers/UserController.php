<?php
class UserModel extends BaseModel
{
    const TABLE = 'users'; // tên bảng user trong DB

    public function getAll($select = ['*'], $orderBys = [], $limit = 15)
    {
        return $this->all(self::TABLE, $select, $orderBys, $limit);
    }

}
