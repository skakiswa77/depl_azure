<?php
// Configuration pour l'API

// Détecter l'environnement (local ou Azure)
$isAzure = (getenv('WEBSITE_SITE_NAME') !== false);

if ($isAzure) {
    // Connexion Azure SQL
    $dbServer = getenv('grpe1-server');
    $dbName = getenv('grpe1-database');
    $dbUser = getenv('cuxcamgiac');
    $dbPassword = getenv('w45$wuVtiZT9x$$r');
} else {
    // Connexion locale MAMP
    $dbServer = '127.0.0.1';  // ou '127.0.0.1'
    $dbName = 'fullstack_db';
    $dbUser = 'root';
    $dbPassword = 'root';     // MAMP utilise 'root' comme mot de passe par défaut
}

// Fonction pour se connecter à la base de données
function getDbConnection() {
    global $dbServer, $dbName, $dbUser, $dbPassword, $dbPort, $isAzure;
    
    try {
        if ($isAzure) {
            // Pour SQL Server/Azure SQL
            $conn = new PDO("sqlsrv:Server=$dbServer;Database=$dbName", $dbUser, $dbPassword);
        } else {
            // Pour MySQL local avec MAMP
            $dsn = "mysql:host=$dbServer;port=$dbPort;dbname=$dbName;charset=utf8mb4";
            $conn = new PDO($dsn, $dbUser, $dbPassword);
        }
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        // Log l'erreur pour le débogage
        error_log("Erreur de connexion à la base de données: " . $e->getMessage());
        
        // En développement, on peut afficher plus d'informations
        if (!$isAzure) {
            error_log("DSN: mysql:host=$dbServer;port=$dbPort;dbname=$dbName");
            error_log("User: $dbUser");
        }
        
        return null;
    }
}
