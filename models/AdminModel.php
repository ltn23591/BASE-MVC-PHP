<?php

class AdminModel extends BaseModel
{
    const TABLE = 'products';
    public function getAll($select = ['*'], $orderBys = [], $limit = 15)
    {
        return $this->all(self::TABLE, $select, $orderBys, $limit);
    }
    public function findById($id)
    {
        return $this->find(self::TABLE, $id);
    }
    public function store($data)
    {
        $this->create(self::TABLE, $data);
    }
    public function updateData($id, $data)
    {
        $this->update(self::TABLE, $id, $data);
    }
    public function destroy($id)
    {
        $this->delete(self::TABLE, $id);
    }
}
