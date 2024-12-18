<?php
session_start();
include 'db_config.php'; // Include the database connection

// Check if a cancel request is made
if (isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id'];

    // Prepare and execute the stored procedure to cancel the order
    $stmt = $pdo->prepare("CALL CancelOrder(:order_id)");
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();

    $_SESSION['message'] = "Order #$order_id has been canceled.";
    header("Location: orders.php"); // Redirect to orders page
    exit();
}

// Fetch all orders to display
$stmt = $pdo->prepare("SELECT * FROM orders WHERE status != 'canceled' ORDER BY order_date DESC");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
