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
    public function delete($table,$id) {
        $sql = "DELETE FROM $table WHERE id = $id";
        $this->_query($sql);
    }
    public function add() {}


    private function _query($sql)
    {
        return mysqli_query($this->conn, $sql);
    }
}