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

   

  </style>
</head>
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
        <!-- Inventory Table -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Inventory</h3>
                <form method="GET" action="inventory_sales.php" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Search Inventory">
                    <button type="submit" class="btn btn-dark ms-2">Search</button>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Inventory ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($inventory)) : ?>
                            <?php foreach ($inventory as $item) : ?>
                                <tr>
                                    <td><?= $item['inventory_id'] ?></td>
                                    <td><?= $item['product_name'] ?></td>
                                    <td>
                                        <form method="POST" action="inventory_sales.php">
                                            <input type="hidden" name="product_id" value="<?= $item['inventory_id'] ?>">
                                            <input type="number" name="quantity_sold" class="form-control" min="1" max="<?= $item['stock_quantity'] ?>" required>
                                            <button type="submit" name="sell_product" class="btn btn-success btn-sm mt-2">Sell</button>
                                        </form>
                                    </td>
                                    <td>$<?= number_format($item['product_price'], 2) ?></td>
                                    <td>
                                        <a href="edit_inventory.php?inventory_id=<?= $item['inventory_id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5">No inventory items found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daily Sales Report -->
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Today's Sales</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity Sold</th>
                            <th>Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sales)) : ?>
                            <?php foreach ($sales as $sale) : ?>
                                <tr>
                                    <td><?= $sale['product_name'] ?></td>
                                    <td><?= $sale['total_quantity_sold'] ?></td>
                                    <td>$<?= number_format($sale['total_revenue'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3">No sales today.</td>
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
