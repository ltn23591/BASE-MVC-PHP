<?php
class Database
{
    const HOST = 'localhost';
    const USERNAME = 'root';
    const PASSWORD = '';
    const DB_NAME = 'phpstore';

    private $conn;

    public function connect()
    {
        $this->conn = new mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DB_NAME);
        try {
            if ($this->conn->connect_errno) {
                throw new Exception("Connect failed: " . $this->conn->connect_error);
            }
            $this->conn->set_charset("utf8");
            return $this->conn;
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            exit();
        }
    }
}