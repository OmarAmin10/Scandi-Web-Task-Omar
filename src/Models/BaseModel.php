<?php

namespace App\Models;
use App\Config\Database;

abstract class BaseModel
{
    protected $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    protected function executeQuery($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    abstract protected function getTableName();
}
?>