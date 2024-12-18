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

    /* Popup Styles */
    .modal-backdrop {
      z-index: 1040 !important;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <div class="header">
    <div class="logo">
      <img src="image/cpc.png" alt="CPC Logo" onclick="navigateTo('user_dashboard.html')"> <!-- Replace with actual logo -->
    </div>
    <div class="logo1">
        <img src="image/logo1.png" alt="ESSEN Logo" onclick="navigateTo('user_dashboard.html')"> <!-- Replace with actual logo -->
      </div>
    <div class="icons">
        <i class="bi bi-cart-dash-fill" id="cartIcon" onclick="navigateTo('cart.html')"></i>
      <i class="bi bi-bell-fill"></i>
      <i class="bi bi-person-circle"></i>
      <i class="bi bi-power" onclick="logoutUser()"></i>
    </div>
  </div>

  <!-- Main Dashboard -->
  <div class="container dashboard-section mt-4">
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card p-4 text-center" style="width: 16rem; height: 22rem;" onclick="showAddToCartPopup('IT POLO', '1')">
          <img src="image/polo.png" alt="Shop" style="width: 200px; height: 250px; object-position: center;">
          <h5 class="mt-3">IT POLO</h5>
        </div>
      </div>
      <!-- Add other products similarly -->
    </div>
  </div>

  <!-- Add to Cart Confirmation Modal -->
  <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addToCartModalLabel">Add to Cart</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to add this item to your cart?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="confirmAddToCartButton" onclick="addToCart()">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let selectedProduct = '';
    let selectedProductId = '';

    // Show Add to Cart Popup
    function showAddToCartPopup(productName, productId) {
      selectedProduct = productName;
      selectedProductId = productId;
      // Show the modal
      var myModal = new bootstrap.Modal(document.getElementById('addToCartModal'));
      myModal.show();
    }

    // Add product to cart (backend interaction)
    function addToCart() {
      // Example of sending data to the backend using AJAX
      fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          productId: selectedProductId,
          productName: selectedProduct,
        }),
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Item added to cart!');
          document.getElementById('cartIcon').click();  // Redirect to cart page
        } else {
          alert('Failed to add item to cart.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });

      // Close the modal
      var myModal = new bootstrap.Modal(document.getElementById('addToCartModal'));
      myModal.hide();
    }

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
