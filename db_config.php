<?php
// Database configuration
$host = 'localhost'; // Database host (usually localhost)
$dbname = 'schoolshop'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set PDO attributes for error handling and fetch mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Error handling
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Fetch associative arrays by default
    
    // Optionally, you can enable UTF-8 support
    $pdo->exec("SET NAMES 'utf8mb4'");
    
} catch (PDOException $e) {
    // Catch any connection errors and display a message
    die("Connection failed: " . $e->getMessage());
}
?>
