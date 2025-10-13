<?php

class ProductModel extends BaseModel
{
    const TABLE = 'products';

    public function getPaginated($limit = 16, $offset = 0, $orderBys = [])
    {
        $orderColumn = $orderBys['column'] ?? 'id';
        $orderDirection = $orderBys['order'] ?? 'DESC';

        $sql = "SELECT * FROM " . self::TABLE . " 
                ORDER BY {$orderColumn} {$orderDirection} 
                LIMIT {$limit} OFFSET {$offset}";

        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM " . self::TABLE;
        $result = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }

    public function store($data)
    {
        $this->create(self::TABLE, $data);
    }

    public function findById($id)
    {
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
