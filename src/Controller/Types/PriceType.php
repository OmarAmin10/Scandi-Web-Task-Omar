<?php

namespace App\Controller\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PriceType extends ObjectType
{
    public function __construct()
    {

        $currencyType = new PriceCurrencyType(); 
        parent::__construct([
            'name' => 'Price',
                'fields' => [
                    'amount' => Type::string(),
                    'currency' => $currencyType, // ✅ Correct reference
                ],
        ]);
    }
}
?>