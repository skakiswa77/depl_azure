<?php

require_once 'api_client.php';


$client = new ApiClient($apiBaseUrl);


$products = [];
$error = null;

try {
    $products = $client->get('products');
} catch (Exception $e) {
    $error = $e->getMessage();
}


showFlashMessages();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Liste des produits</h1>
    <a href="index.php?page=product_form" class="btn btn-primary">Ajouter un produit</a>
</div>

<?php if ($error): ?>
<div class="alert alert-danger">
    <?php echo htmlspecialchars($error); ?>
</div>
<?php endif; ?>

<?php if (empty($products) && !$error): ?>
<div class="alert alert-info">
    Aucun produit disponible.
</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['id']); ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['description']); ?></td>
                <td><?php echo number_format($product['price'], 2); ?> €</td>
                <td><?php echo htmlspecialchars($product['stock_quantity']); ?></td>
                <td>
                    <a href="index.php?page=product_form&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                    <button 
                        type="button" 
                        class="btn btn-sm btn-danger delete-product" 
                        data-id="<?php echo $product['id']; ?>"
                        data-name="<?php echo htmlspecialchars($product['name']); ?>"
                    >
                        Supprimer
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer le produit <span id="productName"></span> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
 
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const productNameElem = document.getElementById('productName');
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    let productIdToDelete = null;

    document.querySelectorAll('.delete-product').forEach(button => {
        button.addEventListener('click', function() {
            productIdToDelete = this.getAttribute('data-id');
            productNameElem.textContent = this.getAttribute('data-name');
            deleteModal.show();
        });
    });
    

    confirmDeleteBtn.addEventListener('click', function() {
        if (productIdToDelete) {
            window.location.href = `delete_product.php?id=${productIdToDelete}`;
        }
    });
});
</script>
<?php endif; ?>

    
