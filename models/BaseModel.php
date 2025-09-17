<?php
class BaseModel extends Database
{
    protected $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function all($table, $select = ['*'], $orderBys = [], $limit = 15)
    {

        $column = implode(',', $select);

        $orderByString = implode(' ', $orderBys);

        if ($orderByString) {
            $sql = "SELECT $column FROM $table ORDER BY $orderByString LIMIT $limit";
        } else {
            $sql = "SELECT $column FROM $table LIMIT $limit";
        }


        $query = $this->_query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }
        return $data;
    }
    public function find($table, $id)
    {
        $sql = "SELECT * FROM $table WHERE id = $id LIMIT 1";
        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }
    public function findEmail($table, $email)
    {
        $sql = "SELECT * FROM $table WHERE email = '$email' LIMIT 1";
        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }
    public function create($table, $data = [])
    {
        $column = implode(',', array_keys($data));

        // Lặp từng values để đặt dấu ' giữa các values
        $newValues = array_map(function ($value) {
            return "'" . $value . "'";
        }, array_values($data));

        $newValues = implode(",", $newValues);
        $sql = "INSERT INTO $table($column) VALUES ($newValues)";

        $this->_query($sql);
    }
    public function update($table, $id, $data)
    {
        $dataSets = [];
        foreach ($data as $key => $val) {
            array_push($dataSets, "$key = '" . $val . "'");
        }
        $dataSetString = implode(',', $dataSets);
        $sql = "UPDATE $table SET $dataSetString WHERE id = $id";

        $this->_query($sql);
    }
    public function getByQuery($sql)
    {
        $query = $this->_query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }
        return $data;
    }
    public function delete($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id = $id";
        $this->_query($sql);
    }
    public function add() {}


    private function _query($sql)
    {
        return mysqli_query($this->conn, $sql);
    }
    public function filter($search = '', $categories = [], $subCategories = [], $sort = 'relavent')
    {
        $sql = "SELECT * FROM products WHERE 1";

        if (!empty($search)) {
            $search = mysqli_real_escape_string($this->conn, $search);
            $sql .= " AND name LIKE '%$search%'";
        }

        if (!empty($categories)) {
            $cats = implode("','", array_map(fn($c) => mysqli_real_escape_string($this->conn, $c), $categories));
            $sql .= " AND category IN ('$cats')";
        }

        if (!empty($subCategories)) {
            $subs = implode("','", array_map(fn($s) => mysqli_real_escape_string($this->conn, $s), $subCategories));
            $sql .= " AND subCategory IN ('$subs')";
        }

        if ($sort === 'low-high') {
            $sql .= " ORDER BY price ASC";
        } elseif ($sort === 'high-low') {
            $sql .= " ORDER BY price DESC";
        } else {
            $sql .= " ORDER BY id DESC";
        }

        $result = mysqli_query($this->conn, $sql);

        // 📌 Quan trọng: trả về mảng, không để null
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return []; // nếu không có kết quả vẫn trả về mảng rỗng
    }
}