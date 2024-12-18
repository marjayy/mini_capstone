<?php
session_start();
include 'db_config.php';  // Database connection file

// Initialize the variables
$orders = [];

try {
    // Fetch all orders
    $stmt = $pdo->query("CALL FetchAllOrders()"); // Assuming a stored procedure called FetchAllOrders exists
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

// Function to cancel order
if (isset($_GET['cancel_order'])) {
    $orderId = $_GET['cancel_order'];
    try {
        // Call stored procedure to cancel the order
        $stmt = $pdo->prepare("CALL CancelOrder(:order_id)");
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: orders.php"); // Redirect back to orders page
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="shortcut icon" type="x-icon" href="image/logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .dashboard-header {
      background-color: #000000;
      color: #ffffff;
      padding: 10px 20px;
    }

    .dashboard-card {
      text-align: center;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background: #ffffff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 100%;
      cursor: pointer;
    }

    .dashboard-card h5 {
      font-size: 24px;
      font-weight: 600;
      margin: 0;
    }

    .dashboard-card p {
      font-size: 18px;
      font-weight: bold;
      margin-top: 5px;
    }

    .table th, .table td {
      text-align: center;
    }

    .table th {
      background-color: #343a40;
      color: white;
    }

    .table td button {
      margin: 0 5px;
    }

    .left-logo {
      max-width: 13%;
    }

    .row.g-4 {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .col-md-2 {
      flex: 1 1 22%;
      margin-bottom: 20px;
    }

    .header {
      background-color: #000000;
      color: #ffffff;
      padding: 10px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header .logo {
      font-size: 24px;
      font-weight: bold;
      display: flex;
      align-items: center;
    }

    .header .logo img {
      max-width: 160px;
      margin-right: 10px;
    }

    .header .title {
      font-size: 22px;
      font-weight: 600;
    }

    .header .icons {
      display: flex;
      align-items: center;
    }

    .header .icons i {
      font-size: 20px;
      margin-left: 20px;
      cursor: pointer;
    }

    .header .icons i:hover {
      color: #ddd;
    }

    .table {
        border-color: #000000;
        background-color: #ffffff;
    }
    .table th {
        background-color: #ffffff;
        color: #000000;
    }

    .card {
        border-radius: 0px;
        border-color: #000000;
    }
    .card-header {
        background-color: #ffffff;
        border-bottom: #ffffff;
    }

   /* Style for the search bar */
    .search-box {
    display: flex;
    justify-content: flex-end;
    }   

    .search-box input {
    width: 250px; /* Adjust this for the size of the search box */
    padding: 1px 20px; /* Adjust the internal space inside the box */
    font-size: 15px; /* Increase font size for better readability */
    border-radius: 5px;
    border: 1px solid #000000;
   
    }

    .search-box button {
    margin-left: 10px;
    background-color: #000000;
    border: none;
    border-radius: 5px;
    padding: 5px 10px; /* Adjust button size */
    cursor: pointer;
    }

    .search-box button:hover {
    background-color: #ffffff;
    }

  </style>
</head>
<body>
  <div class="header">
    <div class="logo">
      <img src="image/logo1.png" alt="ESSEN Logo">
    </div>
    <div class="title">Admin Dashboard</div>
    <div class="icons">
      <i class="bi bi-bell"></i>
      <i class="bi bi-person-circle"></i>
      <i class="bi bi-power"></i>
    </div>
  </div>
  <div class="container mt-5">
    <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0" style="padding-left: 5%">ORDERS</h3>
            <div class="search-box">
                <input type="text" class="form-control" placeholder="Search Orders">
                <button class="btn btn-primary">Search</button>
    </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)) : ?>
                        <?php foreach ($orders as $order) : ?>
                            <tr>
                                <td><?= $order['order_id'] ?></td>
                                <td><?= $order['user_id'] ?></td>
                                <td><?= $order['product_name'] ?></td>
                                <td><?= $order['quantity'] ?></td>
                                <td>$<?= number_format($order['price'], 2) ?></td>
                                <td>
                                    <?php if ($order['status'] == 'Pending') : ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif ($order['status'] == 'Shipped') : ?>
                                        <span class="badge bg-success">Shipped</span>
                                    <?php elseif ($order['status'] == 'Canceled') : ?>
                                        <span class="badge bg-danger">Canceled</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($order['status'] == 'Pending') : ?>
                                        <a href="orders.php?cancel_order=<?= $order['order_id'] ?>" class="btn btn-danger btn-sm">
                                            <i class="bi bi-x-circle"></i> Cancel
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
