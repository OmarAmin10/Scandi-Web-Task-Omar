<?php

namespace App\Models;

require_once __DIR__ . '/BaseModel.php';
use PDO;

class Gallery extends BaseModel
{

    protected function getTableName()
    {
        return "product_gallery";
    }
    public function getProductGallery($id)
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table} WHERE product_id = :id";
        $stmt = $this->executeQuery($sql, [':id' => $id]);
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $gallery = [];
        foreach ($images as $image) {
            array_push($gallery, $image['image_url']);
        }
        return $gallery;
    }
}

?>