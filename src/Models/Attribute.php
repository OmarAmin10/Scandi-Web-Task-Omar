<?php

namespace App\Models;

require_once __DIR__ . '/BaseModel.php';
use PDO;

class Attribute extends BaseModel
{

    protected function getTableName()
    {
        return "product_attributes";
    }

    public function getProductAttributes($id)
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table}
                INNER JOIN attributes ON attributes.id = product_attributes.attribute_id 
                WHERE product_id = :id";
        $stmt = $this->executeQuery($sql, [':id' => $id]);
        $productsAttributes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $attributes = [];
        foreach ($productsAttributes as $item) {
            $attributeId = $item['attribute_id'];

            if (!isset($attributes[$attributeId])) {
                $attributes[$attributeId] = [
                    'id' => $item['attribute_id'],
                    'name' => $item['name'],
                    'type' => $item['type'],
                    'items' => [],
                ];
            }

            $attributes[$attributeId]['items'][] = [
                'id' => $item['id'],
                'attribute_id' => $attributeId,
                'value' => $item['value'],
                'displayValue' => $item['displayValue'],
            ];
        }

        return $attributes; // ✅ Reset array keys for JSON formatting
    }
}

?>