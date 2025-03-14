<?php

namespace App\Models;

require_once __DIR__ . '/BaseModel.php';
use PDO;
use PDOException;

class Product extends BaseModel
{
    protected function getTableName()
    {
        
        return "products";
    }
    public function getAllProducts()
    {
        
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table}";
        $stmt = $this->executeQuery($sql);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $gallery = new Gallery();
        $i = new Attribute();
        $p = new Price();
        foreach ($products as &$product) {
            $product['gallery'] = $gallery->getProductGallery($product['id']);
            $attributes = $i->getProductAttributes($product['id']);
            $product['attributes'] = $attributes;
            $newPrices = $p->getAllProductPrices($product['id']);
            $product['price'] = $newPrices;
        }
        
        return $products;
    }

    public function getProductById($id)
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table} WHERE id=:id";
        $stmt = $this->executeQuery($sql, [':id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            return null; 
        }

        $gallery = new Gallery();
        $product['gallery'] = $gallery->getProductGallery($product['id']);
        $i = new Attribute();
        $attributes = $i->getProductAttributes($product['id']);
        $product['attributes'] = $attributes;
        $p = new Price();
        $newPrices = $p->getAllProductPrices($product['id']);
        $product['price'] = $newPrices;



        return $product;
    }

    public function getProductsByCategory($category)
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM products WHERE category=:category";
        $stmt = $this->executeQuery($sql, [':category'=> $category]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $gallery = new Gallery();
        $i = new Attribute();
        $p = new Price();
        foreach ($products as &$product) {
            $product['gallery'] = $gallery->getProductGallery($product['id']);
            $attributes = $i->getProductAttributes($product['id']);
            $product['attributes'] = $attributes;
            $newPrices = $p->getAllProductPrices($product['id']);
            $product['price'] = $newPrices;
        }
        
        return $products;
    }
}

?>