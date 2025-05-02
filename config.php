<?php

$isAzure = (getenv('WEBSITE_SITE_NAME') !== false);

if ($isAzure) {

    $apiBaseUrl = getenv('API_URL') ?: 'https://fullstack-php-api.azurewebsites.net';
} else {
  
    $apiBaseUrl = 'http://localhost/api';
}


session_start();


function showFlashMessages() {
    if (isset($_SESSION['flash_message'])) {
        $type = $_SESSION['flash_type'] ?? 'info';
        echo '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">';
        echo $_SESSION['flash_message'];
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
    }
}