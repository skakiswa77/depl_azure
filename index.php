<?php 

require_once 'config.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'products';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Full Stack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Full Stack</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class= "nav-link <?php echo $page === 'products' ? 'active' : ''; ?>" href="index.php">Produits</a>
</li>
</ul>
</div>
</div>
</nav>

<div class="container mt-4">
    <?php

    switch ($page){
        case 'products':
            include 'products.php';
            break;
            case 'product_form':
                include 'product_form.php';
                break;
                default:
                echo '<div class="alert alert-danger">Page non trouvé</div>';
                break;

    }
    ?>
    </div>

    <footer class = "big-light text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; <?php echo date ('Y'); ?> Full Stack Demo</p>
</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>   
</body>
</html>