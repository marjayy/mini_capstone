<?php
session_start();

// Retrieve POST data from AJAX request
$data = json_decode(file_get_contents('php://input'), true);

$productId = $data['productId'];
$productName = $data['productName'];
$size = $data['size'];

// Hardcoded price and image (can be dynamic from DB)
$productPrice = 550;
$productImage = "image/polo.png";

// Initialize cart if not already
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Check if product is already in the cart
$existingItemIndex = -1;
foreach ($_SESSION['cart'] as $index => $item) {
  if ($item['productName'] === $productName && $item['size'] === $size) {
    $existingItemIndex = $index;
    break;
  }
}

// If product exists, increase quantity, otherwise add new item
if ($existingItemIndex >= 0) {
  $_SESSION['cart'][$existingItemIndex]['quantity']++;
} else {
  $_SESSION['cart'][] = [
    'productId' => $productId,
    'productName' => $productName,
    'size' => $size,
    'price' => $productPrice,
    'quantity' => 1,
    'image' => $productImage
  ];
}

// Return a success response
echo json_encode(['success' => true]);
?>
