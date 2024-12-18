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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Cancel Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table th, .table td {
            text-align: center;
        }
        .table th {
            background-color: #343a40;
            color: white;
        }
        .table td {
            padding: 15px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Orders</h2>

    <!-- Display Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <!-- Orders Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Size</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['order_id']) ?></td>
                        <td><?= htmlspecialchars($order['user_id']) ?></td>
                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                        <td><?= htmlspecialchars($order['quantity']) ?></td>
                        <td><?= htmlspecialchars($order['size']) ?></td>
                        <td>
                            <?php if ($order['status'] == 'pending'): ?>
                                <form method="POST" action="cancel_order.php">
                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                    <button type="submit" name="cancel_order" class="btn btn-danger btn-sm">Cancel Order</button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted">Cannot cancel</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No orders found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
