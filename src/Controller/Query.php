<?php

namespace App\Controller;

use App\Controller\Types\CategoryType;
use App\Models\Category;
use App\Models\Product;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Controller\Types\ProductType;


class Query
{
    public function Queries()
    {
        $productType = new ProductType();
        $productModel = new Product();
        $categoryType = new CategoryType();
        $category = new Category();
        return new ObjectType([
            'name' => 'Query',
            'fields' => [
                'getAllProducts' => [
                    'type' => Type::listOf($productType),
                    'description' => 'Fetch all products',
                    'resolve' => fn() => $productModel->getAllProducts()
                ],

                'getProductById' => [
                    'type' => $productType, // Returns a single product
                    'description' => 'Fetch a product by ID',
                    'args' => [
                        'id' => Type::nonNull(Type::string()), // Required ID argument
                    ],
                    'resolve' => function ($root, $args) use ($productModel) {
                        return $productModel->getProductById($args['id']); // Pass ID to the model
                    }
                ],
                'getAllCategories' => [
                    'type' => Type::listOf($categoryType),
                    'description' => 'Fetch all categories',
                    'resolve' => fn() => $category->getAllCategories()
                ],
                'getProductByCategory' => [
                    'type' => Type::listOf($productType), // Should return a list of products
                    'description' => 'Fetch products by category',
                    'args' => [
                        'category' => Type::nonNull(Type::string()), // Required category argument
                    ],
                    'resolve' => function ($root, $args) use ($productModel) {
                        return $productModel->getProductsByCategory($args['category']); // Call correct method
                    }
                ],



            ],
        ]);
    }
}
