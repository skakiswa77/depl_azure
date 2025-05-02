<?php

require_once 'config.php';
require_once 'api_client.php';


if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['flash_message'] = "ID de produit non spécifié";
    $_SESSION['flash_type'] = "danger";
    header('Location: index.php');
    exit;
}

$productId = intval($_GET['id']);


$client = new ApiClient($apiBaseUrl);


try {
    $client->delete('products', $productId);
    $_SESSION['flash_message'] = "Produit supprimé avec succès!";
    $_SESSION['flash_type'] = "success";
} catch (Exception $e) {
    $_SESSION['flash_message'] = "Erreur lors de la suppression: " . $e->getMessage();
    $_SESSION['flash_type'] = "danger";
}


header('Location: index.php');
exit;