<?php
session_start();
include 'db_config.php';  // Database connection file

// Initialize the variables
$userCount = $orderCount = $inventoryCount = $productCount = $cancelCount = 0;

try {
    // Fetch total users
    $stmt = $pdo->query("CALL FetchUsers()");
    $userCount = $stmt->fetchColumn();
    $stmt->closeCursor();

    // Fetch total orders
    $stmt = $pdo->query("CALL FetchOrders()");
    $orderCount = $stmt->fetchColumn();
    $stmt->closeCursor();

    // Fetch total inventory
    $stmt = $pdo->query("CALL FetchInventory()");
    $inventoryCount = $stmt->fetchColumn();
    $stmt->closeCursor();

    // Fetch total products
    $stmt = $pdo->query("CALL FetchProducts()");
    $productCount = $stmt->fetchColumn();
    $stmt->closeCursor();

    // Fetch total canceled orders
    $stmt = $pdo->query("CALL FetchCancellations()");
    $cancelCount = $stmt->fetchColumn();
    $stmt->closeCursor();

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
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
      <i class="bi bi-power" onclick="logoutUser()"></i>
    </div>
  </div>

  <div class="container mt-5">
    <div class="row g-4">
      <div class="col-md-2">
        <div class="dashboard-card" onclick="window.location.href='orders.php'">
          <h5 class="text-center"><i class="bi bi-cart-dash"></i> Orders</h5>
          <p>(<?= $orderCount ?>)</p>
        </div>
      </div>
      <div class="col-md-2">
        <div class="dashboard-card" onclick="window.location.href='inventory.php'">
          <h5 class="text-center"><i class="bi bi-box"></i> Inventory</h5>
          <p>(<?= $inventoryCount ?>)</p>
        </div>
      </div>
      <div class="col-md-2">
        <div class="dashboard-card" onclick="window.location.href='products.php'">
          <h5 class="text-center"><i class="bi bi-bag-check"></i> Products</h5>
          <p>(<?= $productCount ?>)</p>
        </div>
      </div>
      <div class="col-md-2">
        <div class="dashboard-card" onclick="window.location.href='user.php'">
          <h5 class="text-center"><i class="bi bi-person-circle"></i> User</h5>
          <p>(<?= $userCount ?>)</p>
        </div>
      </div>
      <div class="col-md-2">
        <div class="dashboard-card" onclick="window.location.href='user_management.php'">
          <h5 class="text-center"><i class="bi bi-person-circle"></i> Manage User</h5>
          <p>(2)</p>
        </div>
      </div>
      <div class="col-md-2">
        <div class="dashboard-card" onclick="window.location.href='cancel_orders.php'">
          <h5 class="text-center"><i class="bi bi-ban"></i> Canceled Orders</h5>
          <p>(<?= $cancelCount ?>)</p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navigate to a specific page
    function navigateTo(page) {
      window.location.href = page;
    }

    // Log out user
    function logoutUser() {
      if (confirm("Are you sure you want to log out?")) {
        window.location.href = "login.html"; // Redirect to index.php for logout
      }
    }
  </script>
</body>
</html>
