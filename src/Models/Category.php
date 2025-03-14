<?php

namespace App\Models;

require_once __DIR__ . '/BaseModel.php';
use PDO;

class Category extends BaseModel
{
    protected function getTableName()
    {
        return "categories";
    }
    public function getAllCategories(){
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table}";
        $stmt = $this->executeQuery($sql);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $categories;
    }
}
?>