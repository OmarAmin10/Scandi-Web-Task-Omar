<?php

namespace App\Models;

require_once __DIR__ . '/BaseModel.php';
use PDO;
use PDOException;

class Price extends BaseModel
{
    protected function getTableName()
    {
        return "prices";
    }
    public function getAllProductPrices($id)
    {

        $sql = "SELECT currency, amount, symbol FROM prices INNER JOIN currencies ON prices.currency =currencies.label WHERE product_id=:id;";
        $stmt = $this->executeQuery($sql, [':id' => $id]);
        $prices = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert `gallery` from null/string to array
        $productPrices = [];
        foreach ($prices as $price) {
            $productPrices[] = [
                'amount' => number_format($price['amount'], 2, thousands_separator: ''),
                'currency' => [
                    'label' => $price['currency'],
                    'symbol' => $price['symbol'],
                ],
            ];
        }
        return $productPrices;
    }
}

?>