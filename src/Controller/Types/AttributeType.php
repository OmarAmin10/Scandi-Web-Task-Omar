<?php

namespace App\Controller\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeType extends ObjectType
{
    public function __construct()
    {
        $attributeItemType = new AttributeItemType();
        parent::__construct([
            'name' => 'Attribute',
                'fields' => [
                    'id' => Type::string(),
                    'name' => Type::string(),
                    'type' => Type::string(),
                    'items' => Type::listOf($attributeItemType), // ✅ Correct reference
                ],
        ]);
    }
}
?>