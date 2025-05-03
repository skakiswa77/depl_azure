<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    exit(0);
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$resource =end($uri);

if ($resource === 'products' || $resource === 'products.php'){
    require_once 'products.php';
} elseif($resource === 'health'){
    echo json_encode(['status' => 'OK']);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Resource not found']);
}

