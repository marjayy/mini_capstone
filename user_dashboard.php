<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link rel="shortcut icon" type="x-icon" href="image/cpc.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #ffffff;
    }

    .header {
      background-color: #000000;
      color: #ffffff;
      padding: 10px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed; /* Make the header fixed at the top */
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000; /* Ensure it stays on top */
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional: adds a shadow under the header */
    }

    .header .logo {
      font-size: 24px;
      font-weight: bold;
      display: flex;
      align-items: center;
    }

    .header .logo img {
      max-width: 55px;
      margin-right: 10px;
    }

    .header .logo1 img {
        max-width: 160px;
        margin-right: 10px;
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

    .dashboard-section {
      padding: 20px;
    }

    .card {
      cursor: pointer;
      transition: transform 0.2s ease;
      border: #ffffff;
      margin-top: 30px;
    }

    .card:hover {
      transform: scale(1.05);
    }

    .order-table th, .order-table td {
      text-align: center;
    }

    .order-table th {
      background-color: #343a40;
      color: white;
    }

    .mt-3 {
        font-size: 18px;
        align-items: center;
    }

     
  </style>
</head>
<body>
  <!-- Header -->
  <div class="header">
    <div class="logo">
      <img src="image/cpc.png" alt="CPC Logo"> <!-- Replace with actual logo -->
    </div>
    <div class="logo1">
        <img src="image/logo1.png" alt="ESSEN Logo"> <!-- Replace with actual logo -->
      </div>
    <div class="icons">
        <i class="bi bi-cart-dash-fill"></i>
      <i class="bi bi-bell-fill"></i>
      <i class="bi bi-person-circle"></i>
      <i class="bi bi-power" onclick="logoutUser()"></i>
    </div>
  </div>

  <!-- Main Dashboard -->
  <div class="container dashboard-section mt-4">
  
    <!-- Cards Section -->
    <div class="container dashboard-section mt-4">
        <!-- Cards Section -->
        <div class="row g-4">
          <div class="col-md-3">
            <div class="card p-4  text-center" style="width: 16rem; height: 21rem;" onclick="navigateTo('IT_polo.html')">
              <img src="image/polo.png" alt="Shop" style="width: 200px; height: 250px; object-position: center;">
              <h5 class="mt-3">POLO SHIRTS</h5>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card p-4  text-center" style="width: 16rem; height: 21rem;" onclick="navigateTo('order_history.html')">
                <img src="image/polo.png" alt="Shop" style="width: 200px; height: 250px; object-position: center;">
                <h5 class="mt-3">PE UPPER</h5>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card p-4  text-center" style="width: 16rem; height: 21rem;" onclick="navigateTo('order_history.html')">
                <img src="image/polo.png" alt="Shop" style="width: 200px; height: 250px; object-position: center;">
                <h5 class="mt-3">PE LOWER</h5>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card p-4  text-center" style="width: 16rem; height: 21rem;" onclick="navigateTo('order_history.html')">
                <img src="image/polo.png" alt="Shop" style="width: 200px; height: 250px; object-position: center;">
                <h5 class="mt-3">NSTP</h5>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card p-4  text-center" style="width: 16rem; height: 21rem;" onclick="navigateTo('order_history.html')">
                <img src="image/id.jpg" alt="Shop" style="width: 200px; height: 250px; object-position: center;">
                <h5 class="mt-3">ID LANYARD</h5>
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
        window.location.href = "login.html";
      }
    }
  </script>
</body>
</html>