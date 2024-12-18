<?php
$host = 'localhost'; // Database host
$dbname = 'school_store'; // Database name
$username = 'root'; // Your MySQL username
$password = ''; // Your MySQL password (if any)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
