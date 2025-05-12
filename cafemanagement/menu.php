<?php
session_start();
require_once 'placeorder.php'; 
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $quantity = intval($_POST['quantity']);
    $size = $_POST['size'];
    $type = $_POST['type'];
    $price = floatval($_POST['price']);
    $category = $_POST['category'];

    $total = $price * $quantity;

    $_SESSION['cart'][] = [
        'item_id' => $item_id,
        'item' => $item_name,
        'size' => $size,
        'type' => $type,
        'quantity' => $quantity,
        'price' => $price,
        'total' => $total,
        'category' => $category
    ];
}

if (isset($_GET['delete_item'])) {
    $item_index = $_GET['delete_item'];
    if (isset($_SESSION['cart'][$item_index])) {
        unset($_SESSION['cart'][$item_index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

$categories = [];
$query = "SELECT * FROM menu ORDER BY category, name";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $categories[$row['category']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BrewLane Cafe - Menu</title>
    <style>
        * { 
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }
        
        body {
            background-color: #f8f5f2;
            color: #333;
        }
        
        .header {
            background-color: #854836;
            color: white;
            padding: 15px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .logo img {
            height: 50px;
            margin-right: 10px;
        }
        
        .logo h1 {
            font-size: 24px;
            font-weight: bold;
            color: #f8f5f2;
        }
        
        .nav-buttons a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 20px;
            background-color: rgba(0,0,0,0.2);
            transition: all 0.3s;
        }
        
        .nav-buttons a:hover {
            background-color: #6d3c28;
        }
        
        .container {
            max-width: 1200px;
            margin: 100px auto 40px;
            padding: 0 20px;
        }
        
        .category-section {
            margin-bottom: 40px;
        }
        
        .category-title {
            color: #854836;
            font-size: 28px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #d4b483;
            display: inline-block;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
        }
        
        .menu-item {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            position: relative;
            border: 1px solid #e0d5c8;
        }
        
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        
        .item-image {
            height: 180px;
            background-color: #f1e8dd;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .item-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #d4b483;
            color: #854836;
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 12px;
        }
        
        .item-details {
            padding: 15px;
        }
        
        .item-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
            color: #333;
        }
        
        .item-price {
            color: #854836;
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 15px;
        }
        
        .item-controls {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .item-controls select {
            padding: 8px;
            border: 1px solid #d4b483;
            border-radius: 5px;
            font-size: 14px;
            background-color: #f8f5f2;
        }
        
        .item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .item-quantity input {
            width: 60px;
            padding: 8px;
            border: 1px solid #d4b483;
            border-radius: 5px;
            text-align: center;
            background-color: #f8f5f2;
        }
        
        .add-to-cart {
            background-color: #854836;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .add-to-cart:hover {
            background-color: #6d3c28;
        }
        
        .cart-sidebar {
            position: fixed;
            right: 0;
            top: 80px;
            width: 350px;
            background: white;
            height: calc(100vh - 80px);
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            overflow-y: auto;
            transform: translateX(100%);
            transition: transform 0.3s;
            z-index: 90;
            border-left: 1px solid #e0d5c8;
        }
        
        .cart-sidebar.active {
            transform: translateX(0);
        }
        
        .cart-toggle {
            position: fixed;
            right: 20px;
            top: 80px;
            background-color: #854836;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px 0 0 5px;
            cursor: pointer;
            font-weight: bold;
            z-index: 95;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cart-count {
            background-color: #d4b483;
            color: #854836;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        
        .cart-title {
            font-size: 24px;
            color: #854836;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #d4b483;
        }
        
        .cart-items {
            margin-bottom: 20px;
        }
        
        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #e0d5c8;
        }
        
        .cart-item-name {
            font-weight: bold;
        }
        
        .cart-item-details {
            color: #777;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .cart-item-price {
            color: #854836;
            font-weight: bold;
        }
        
        .cart-total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #d4b483;
        }
        
        .checkout-btn {
            display: block;
            width: 100%;
            background-color: #d4b483;
            color: #854836;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        
        .checkout-btn:hover {
            background-color: #c5a777;
        }
        
        .delete-item {
            color: #854836;
            text-decoration: none;
            font-size: 12px;
            margin-top: 5px;
            display: inline-block;
        }
        
        .empty-cart {
            text-align: center;
            color: #777;
            padding: 30px 0;
        }
        
        @media (max-width: 768px) {
            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
            
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            .logo {
                margin-bottom: 10px;
            }
            
            .nav-buttons {
                margin-top: 10px;
            }
            
            .nav-buttons a {
                margin: 0 5px;
            }
            
            .cart-sidebar {
                width: 100%;
            }
        }
    </style>
    <script>
        function updatePrice(selectElement, basePrice) {
            const priceElement = selectElement.closest('.item-controls').querySelector('.item-price');
            let price = parseFloat(basePrice);
            
            if (selectElement.value === 'Medium') {
                price += 10;
            } else if (selectElement.value === 'Large') {
                price += 20;
            }
            
            priceElement.textContent = '₱' + price.toFixed(2);
            selectElement.closest('.menu-item').querySelector('input[name="price"]').value = price;
        }
        
        function toggleCart() {
            const cartSidebar = document.querySelector('.cart-sidebar');
            cartSidebar.classList.toggle('active');
        }
    </script>
</head>
<body>

<div class="header">
    <div class="header-content">
        <div class="logo">
            <img src="Logo1.png" alt="BrewLane Logo">
            <h1>BrewLane Cafe</h1>
        </div>
        <div class="nav-buttons">
            <a href="neworder.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="login.php">Sign up</a>
            <a href="index.php">Log out</a>
        </div>
    </div>
</div>

<div class="container">
    <?php foreach ($categories as $category => $items): ?>
        <div class="category-section">
            <h2 class="category-title"><?= htmlspecialchars($category) ?></h2>
            <div class="menu-grid">
                <?php foreach ($items as $item): ?>
                    <div class="menu-item">
                        <div class="item-image" style="background-image: url('<?= isset($item['image_path']) ? htmlspecialchars($item['image_path']) : 'breww.jpg' ?>')">

                        </div>
                        <div class="item-details">
                            <div class="item-name"><?= htmlspecialchars($item['name']) ?></div>
                            <div class="item-price">₱<?= number_format($item['price'], 2) ?></div>
                            <form method="post" action="menu.php" class="item-controls">
                           
                                <?php if ($category === 'Beverages'): ?>
                                <select name="size" onchange="updatePrice(this, <?= $item['price'] ?>)">
                                    <option value="Small">Small</option>
                                    <option value="Medium">Medium (+₱10)</option>
                                    <option value="Large">Large (+₱20)</option>
                                </select>
                                <?php else: ?>
                                    <input type="hidden" name="type" value="Regular">
                                <?php endif; ?>
                                
                             
                                <?php if ($category === 'Beverages'): ?>
                                    <select name="type">
                                        <option value="Hot">Hot</option>
                                        <option value="Cold">Cold</option>
                                    </select>
                                <?php else: ?>
                                    <input type="hidden" name="type" value="Regular">
                                <?php endif; ?>
                                
                                <div class="item-quantity">
                                    <input type="number" name="quantity" value="1" min="1">
                                </div>
                                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                <input type="hidden" name="item_name" value="<?= htmlspecialchars($item['name']) ?>">
                                <input type="hidden" name="price" value="<?= $item['price'] ?>">
                                <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
                                <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<button class="cart-toggle" onclick="toggleCart()">
    <span>My Order</span>
    <span class="cart-count"><?= count($_SESSION['cart']) ?></span>
</button>

<div class="cart-sidebar">
    <h2 class="cart-title">My Order</h2>
    <div class="cart-items">
        <?php if (!empty($_SESSION['cart'])): ?>
            <?php 
            $totalAmount = 0;
            foreach ($_SESSION['cart'] as $index => $item): 
                $totalAmount += $item['total'];
            ?>
                <div class="cart-item">
                    <div>
                        <div class="cart-item-name"><?= htmlspecialchars($item['item']) ?></div>
                        <div class="cart-item-details">
                            <?= htmlspecialchars($item['size']) ?> 
                            <?php if ($item['category'] === 'Beverage'): ?>
                                • <?= htmlspecialchars($item['type']) ?>
                            <?php endif; ?>
                            • Qty: <?= $item['quantity'] ?>
                            <a href="?delete_item=<?= $index ?>" class="delete-item">Remove</a>
                        </div>
                    </div>
                    <div class="cart-item-price">₱<?= number_format($item['total'], 2) ?></div>
                </div>
            <?php endforeach; ?>
            <div class="cart-total">
                Total: ₱<?= number_format($totalAmount, 2) ?>
            </div>
            <a href="payment.php" class="checkout-btn">Checkout Now</a>
        <?php else: ?>
            <div class="empty-cart">Your cart is empty</div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>