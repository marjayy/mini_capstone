<?php
session_start();
include 'db_config.php';  // Database connection file

// Initialize the inventory and sales arrays
$inventory = [];
$sales = [];
$totalSale = 0;

// Fetch inventory items and sales data
try {
    // Fetch all inventory items
    $stmt = $pdo->query("CALL FetchAllInventory()");
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch daily sales report (today's sales)
    $stmt_sales = $pdo->query("CALL GetDailySales()");
    $sales = $stmt_sales->fetchAll(PDO::FETCH_ASSOC);

    // Fetch overall total sale for today
    $stmt_total_sales = $pdo->query("CALL GetDailySales()");
    $totalSaleResult = $stmt_total_sales->fetch(PDO::FETCH_ASSOC);
    $totalSale = $totalSaleResult['total_daily_revenue']; // Total revenue for today

    $stmt->closeCursor();
    $stmt_sales->closeCursor();
    $stmt_total_sales->closeCursor();
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

// Handle product sales
if (isset($_POST['sell_product'])) {
    $productId = $_POST['product_id'];
    $quantitySold = $_POST['quantity_sold'];
    try {
        // Check if sufficient stock is available
        $stmt_check = $pdo->prepare("SELECT stock_quantity FROM inventory WHERE product_id = :product_id");
        $stmt_check->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt_check->execute();
        $stock = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($stock && $stock['stock_quantity'] >= $quantitySold) {
            // Call stored procedure to update inventory
            $stmt = $pdo->prepare("CALL UpdateInventoryQuantity(:product_id, :new_quantity)");
            $newQuantity = $stock['stock_quantity'] - $quantitySold;
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':new_quantity', $newQuantity, PDO::PARAM_INT);
            $stmt->execute();

            // Insert a sale record into the sales table
            $stmt_sale = $pdo->prepare("CALL RecordSale(:product_id, :quantity_sold)");
            $stmt_sale->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt_sale->bindParam(':quantity_sold', $quantitySold, PDO::PARAM_INT);
            $stmt_sale->execute();

            // Redirect to refresh the page
            header("Location: inventory_sales.php");
        } else {
            echo "Not enough stock available.";
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
