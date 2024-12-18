<?php
session_start();
include 'db_config.php';  // Database connection file

// Initialize the variables
$orders = [];

try {
    // Function to fetch all orders from the database
    function fetchAllOrders($pdo) {
        $stmt = $pdo->query("CALL FetchAllOrders()"); // Assuming the stored procedure FetchAllOrders exists
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Function to cancel an order by updating its status to 'Canceled'
    function cancelOrder($pdo, $orderId) {
        $stmt = $pdo->prepare("CALL CancelOrder(:order_id)"); // Assuming the stored procedure CancelOrder exists
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Fetch all orders
    $orders = fetchAllOrders($pdo);

    // If the 'cancel_order' parameter is set, cancel the order
    if (isset($_GET['cancel_order'])) {
        $orderId = $_GET['cancel_order'];
        if (cancelOrder($pdo, $orderId)) {
            // Redirect back to the orders page after successful cancellation
            header("Location: orders.php");
            exit();
        } else {
            echo 'Error: Could not cancel the order.';
        }
    }
    
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
