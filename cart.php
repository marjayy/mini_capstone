<?php
$size;
if (isset($_GET['size'])) {
    $size = $_GET['size'];
} else {
    echo "No size selected.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .cart-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .cart-item img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }

        .cart-details {
            flex: 1;
        }

        .cart-details h5 {
            margin: 0 0 5px 0;
            font-size: 18px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-controls button {
            border: none;
            background-color: #333;
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            line-height: 25px;
            text-align: center;
            cursor: pointer;
        }

        .quantity-controls button:hover {
            background-color: #555;
        }

        .cart-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .total-price {
            font-weight: bold;
            font-size: 18px;
        }

        .checkout-btn {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .checkout-btn:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2 class="text-center mb-4">CART</h2>
        
        <div class="cart-item" data-price="550">
            <input type="checkbox" class="item-checkbox">
            <img src="image/polo.png" alt="IT Polo Shirt">
            <div class="cart-details">
                <h5>IT POLO SHIRT</h5>
                <p>Size: <?php echo htmlspecialchars($size) ?></p>
                <p>P 550.00</p>
                <p>192 pieces available</p>
            </div>
            <div class="quantity-controls">
                <button class="decrease-btn">-</button>
                <span class="quantity">1</span>
                <button class="increase-btn">+</button>
            </div>
            <span class="item-total-price">P 550.00</span>
            <button class="btn btn-sm btn-danger remove-btn">&times;</button>
        </div>

        <div class="cart-footer">
            <div>
                <input type="checkbox" id="select-all"> <label for="select-all">Select All (1)</label>
            </div>
            <div class="total-price">Total (1 Item): P <span id="total-price">550.00</span></div>
            <button class="checkout-btn">CHECK OUT</button>
        </div>
    </div>

    <script>
        const cartItem = document.querySelector('.cart-item');
        const quantityElement = cartItem.querySelector('.quantity');
        const itemTotalPriceElement = cartItem.querySelector('.item-total-price');
        const totalPriceElement = document.getElementById('total-price');
        const removeBtn = cartItem.querySelector('.remove-btn');
        const increaseBtn = cartItem.querySelector('.increase-btn');
        const decreaseBtn = cartItem.querySelector('.decrease-btn');
        const itemCheckbox = cartItem.querySelector('.item-checkbox');
        const selectAllCheckbox = document.getElementById('select-all');

        let quantity = 1;
        const itemPrice = parseFloat(cartItem.dataset.price);

        // Update total price of an item
        function updateItemTotalPrice() {
            const total = (itemPrice * quantity).toFixed(2);
            itemTotalPriceElement.textContent = `P ${total}`;
            updateCartTotal();
        }

        // Update overall total price
        function updateCartTotal() {
            if (itemCheckbox.checked) {
                totalPriceElement.textContent = (itemPrice * quantity).toFixed(2);
            } else {
                totalPriceElement.textContent = '0.00';
            }
        }

        // Increase quantity
        increaseBtn.addEventListener('click', () => {
            quantity++;
            quantityElement.textContent = quantity;
            updateItemTotalPrice();
        });

        // Decrease quantity
        decreaseBtn.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                quantityElement.textContent = quantity;
                updateItemTotalPrice();
            }
        });

        // Remove item
        removeBtn.addEventListener('click', () => {
            cartItem.remove();
            updateCartTotal();
        });

        // Checkbox logic
        itemCheckbox.addEventListener('change', updateCartTotal);

        selectAllCheckbox.addEventListener('change', () => {
            itemCheckbox.checked = selectAllCheckbox.checked;
            updateCartTotal();
        });
    </script>
</body>
</html>
