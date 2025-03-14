<?php

namespace App\Controller;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Schema;
use Throwable;
class GraphQL
{
    public static function handle()
    {
        try {
        
            $query = new Query();  
            $queryType = $query->Queries();
            // ✅ Create Schema
            $schema = new Schema([
                'query' => $queryType
            ]);

            // ✅ Read and Validate Input
            $rawInput = file_get_contents('php://input');
            if (!$rawInput) {
                throw new \RuntimeException('No request body received.');
            }

            $input = json_decode($rawInput, true);
            if (!isset($input['query'])) {
                throw new \RuntimeException('No query found in request.');
            }

            // ✅ Execute Query
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;
            $result = GraphQLBase::executeQuery($schema, $query, null, null, $variableValues);
            $output = $result->toArray();

        } catch (Throwable $e) {
            error_log("❌ GraphQL Error: " . $e->getMessage());
            $output = [
                'error' => ['message' => $e->getMessage()],
            ];
        }

        // ✅ Send JSON Response
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($output);
        exit;
    }
}
?>