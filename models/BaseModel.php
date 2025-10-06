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
        $id = (int)$id; // ép kiểu an toàn
        $sql = "DELETE FROM $table WHERE id = $id";
        if (!mysqli_query($this->conn, $sql)) {
            die("Lỗi SQL: " . mysqli_error($this->conn));
        }
    }
    private function _query($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        if ($result === false) {
            // Trong môi trường dev nên in lỗi rõ ràng
            die("SQL ERROR: " . mysqli_error($this->conn) . "\nQuery: " . $sql);
        }
        return $result;
    }

    // Hàm tính tổng
    public function sum($table, $expression, $condition = '1=1')
    {
        $sql = "SELECT SUM($expression) as total FROM $table WHERE $condition";
        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'] ?? 0;
    }
    public function updateAmount($table, $id)
    {
        $sql = "UPDATE $table SET amount = quantity * price WHERE id = $id";
        $this->_query($sql);
    }
}