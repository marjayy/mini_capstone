<?php
session_start();
include 'db_config.php';  // Database connection file

// Initialize the products array
$products = [];

// Handle the search query
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// Fetch products
try {
    if ($searchQuery != '') {
        // Call the stored procedure with a search query to filter products
        $stmt = $pdo->prepare("CALL SearchProducts(:search_query)");
        $stmt->bindParam(':search_query', $searchQuery, PDO::PARAM_STR);
        $stmt->execute();
    } else {
        // If no search query, fetch all products
        $stmt = $pdo->query("CALL FetchAllProducts()");
    }
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

// Handle deleting a product
if (isset($_GET['delete_product'])) {
    $productId = $_GET['delete_product'];
    try {
        // Call stored procedure to delete a product
        $stmt = $pdo->prepare("CALL DeleteProduct(:product_id)");
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: products.php"); // Redirect back to products page after deletion
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

?>

