<?php

class OrderModel extends BaseModel
{
    const TABLE = 'orders';
    public function getAll($select = ['*'], $orderBys = [], $limit = 15)
    {
        return $this->all(self::TABLE, $select, $orderBys, $limit);
    }
    public function store($data)
    {
        $this->create(self::TABLE, $data);
    }
    public function findById($id)
    {
        // return [
        //     'id' => $id,
        //     'name' => 'Iphone 14 Pro Max',
        //     'price' => '30000000'
        // ];
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
   
}