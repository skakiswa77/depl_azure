<?php

require_once 'config.php';

$conn = getDbConnection();
if (!$conn){
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

$id = null;
if (isset($_GET['id'])){
    $id = intval($_GET['id']);
}

switch($method){
    case 'GET':

        if ($id){
            $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product){
                echo json_encode($product);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Product not found']);
            }
        } else {

            $stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($products);
        }
        break;

        case 'POST':

            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['name']) || empty($data['name'])){
                http_response_code(400);
                echo json_encode(['error' => 'Name is required']);
                break;
            }

            $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock_quantity) VALUES (?,?,?,?)");
            $result = $stmt->execute([
                $data['name'],
                $data['description'] ?? '',
                floatval($data['price'] ?? 0),
                intval($data['stock_quantity'] ?? 0)
            ]);

            if ($result){
                $data['id'] = $conn->lastInsertId();
                http_response_code(201);
                echo json_encode($data);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to create product']);
            }
            break;

            
        case 'PUT':

           
            if (!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID is required']);
                break;
            }

            $data = json_decode(file_get_contents('php://input'), true);

            if(!isset($data['name']) || empty($data['name'])){
                http_response_code(400);
                echo json_encode(['error' => 'Name is required']);
                break;
            }

            $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?,stock_quantity = ? WHERE id = ? ");
            $result = $stmt->execute([
                $data['name'],
                $data['description'] ?? '',
                floatval($data['price'] ?? 0),
                intval($data['stock_quantity'] ?? 0),
                $id
            ]);

            if ($result){
                $data['id'] = $id;
                echo json_encode($data);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update product']);
            }
            break;

            
        case 'DELETE':

            if (!$id){
                http_response_code(400);
                echo json_encode(['error' => 'ID is required']);
                break;
            }

           $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
           $result = $stmt->execute([$id]);

            if ($result){
                echo json_encode(['sucess' => true]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to delete product']);
            }
            break;

            default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            break;


}