<?php

require_once 'api_client.php';


$isEdit = isset($_GET['id']) && !empty($_GET['id']);
$productId = $isEdit ? intval($_GET['id']) : null;


$product = [
    'id' => '',
    'name' => '',
    'description' => '',
    'price' => 0,
    'stock_quantity' => 0
];


$client = new ApiClient($apiBaseUrl);

if ($isEdit) {
    try {
        $product = $client->get('products', $productId);
    } catch (Exception $e) {
        $_SESSION['flash_message'] = "Erreur lors de la récupération du produit: " . $e->getMessage();
        $_SESSION['flash_type'] = "danger";
        header('Location: index.php');
        exit;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $productData = [
        'name' => $_POST['name'] ?? '',
        'description' => $_POST['description'] ?? '',
        'price' => floatval($_POST['price'] ?? 0),
        'stock_quantity' => intval($_POST['stock_quantity'] ?? 0)
    ];
    
    try {
        if ($isEdit) {
            
            $client->put('products', $productId, $productData);
            $_SESSION['flash_message'] = "Produit mis à jour avec succès!";
        } else {
            
            $client->post('products', $productData);
            $_SESSION['flash_message'] = "Produit ajouté avec succès!";
        }
        $_SESSION['flash_type'] = "success";
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['flash_message'] = "Erreur: " . $e->getMessage();
        $_SESSION['flash_type'] = "danger";
    }
}


showFlashMessages();
?>

<div class="mb-3">
    <a href="index.php" class="btn btn-secondary">&laquo; Retour à la liste</a>
</div>

<div class="card">
    <div class="card-header">
        <h2><?php echo $isEdit ? 'Modifier' : 'Ajouter'; ?> un produit</h2>
    </div>
    <div class="card-body">
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nom*</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Prix*</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="<?php echo number_format($product['price'], 2, '.', ''); ?>" required>
                        <span class="input-group-text">€</span>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="stock_quantity" class="form-label">Quantité en stock*</label>
                    <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" step="1" min="0" value="<?php echo intval($product['stock_quantity']); ?>" required>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><?php echo $isEdit ? 'Mettre à jour' : 'Ajouter'; ?> le produit</button>
                <a href="index.php" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

