<?php
require_once 'config/database.php';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Testing Checkout & Order System</h2>";
    
    // Check if orders table exists
    $stmt = $db->query("SHOW TABLES LIKE 'orders'");
    $ordersTableExists = $stmt->rowCount() > 0;
    echo "<p>Orders table exists: " . ($ordersTableExists ? "✅ Yes" : "❌ No") . "</p>";
    
    if (!$ordersTableExists) {
        echo "<h3>Creating orders table...</h3>";
        $createOrdersTable = "
            CREATE TABLE orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                order_number VARCHAR(50) UNIQUE NOT NULL,
                status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
                total_amount DECIMAL(10,2) NOT NULL,
                subtotal DECIMAL(10,2) NOT NULL,
                tax_amount DECIMAL(10,2) DEFAULT 0,
                shipping_amount DECIMAL(10,2) DEFAULT 0,
                discount_amount DECIMAL(10,2) DEFAULT 0,
                payment_method VARCHAR(50) NOT NULL,
                payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
                billing_address JSON,
                shipping_address JSON,
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ";
        $db->exec($createOrdersTable);
        echo "<p>✅ Orders table created</p>";
    }
    
    // Check if order_items table exists
    $stmt = $db->query("SHOW TABLES LIKE 'order_items'");
    $orderItemsTableExists = $stmt->rowCount() > 0;
    echo "<p>Order items table exists: " . ($orderItemsTableExists ? "✅ Yes" : "❌ No") . "</p>";
    
    if (!$orderItemsTableExists) {
        echo "<h3>Creating order_items table...</h3>";
        $createOrderItemsTable = "
            CREATE TABLE order_items (
                id INT AUTO_INCREMENT PRIMARY KEY,
                order_id INT NOT NULL,
                product_id INT NOT NULL,
                product_name VARCHAR(255) NOT NULL,
                product_sku VARCHAR(100),
                quantity INT NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                total DECIMAL(10,2) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            )
        ";
        $db->exec($createOrderItemsTable);
        echo "<p>✅ Order items table created</p>";
    }
    
    // Check current orders
    if ($ordersTableExists) {
        $stmt = $db->query("SELECT COUNT(*) as count FROM orders");
        $orderCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "<p>Total orders in database: $orderCount</p>";
        
        if ($orderCount > 0) {
            echo "<h3>Recent Orders:</h3>";
            $stmt = $db->query("
                SELECT o.*, u.first_name, u.last_name, u.email 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC 
                LIMIT 5
            ");
            
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Order #</th><th>Customer</th><th>Status</th><th>Total</th><th>Payment</th><th>Date</th></tr>";
            
            while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$order['order_number']}</td>";
                echo "<td>{$order['first_name']} {$order['last_name']} ({$order['email']})</td>";
                echo "<td>{$order['status']}</td>";
                echo "<td>\${$order['total_amount']}</td>";
                echo "<td>{$order['payment_status']}</td>";
                echo "<td>" . date('M j, Y', strtotime($order['created_at'])) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    
    // Check if user is logged in (for testing)
    session_start();
    $isLoggedIn = isset($_SESSION['user_id']);
    echo "<p>User logged in: " . ($isLoggedIn ? "✅ Yes (ID: {$_SESSION['user_id']})" : "❌ No") . "</p>";
    
    // Check if there are items in cart
    $hasCartItems = isset($_SESSION['cart']) && !empty($_SESSION['cart']);
    echo "<p>Cart has items: " . ($hasCartItems ? "✅ Yes (" . count($_SESSION['cart']) . " items)" : "❌ No") . "</p>";
    
    if ($hasCartItems) {
        echo "<h3>Current Cart Items:</h3>";
        echo "<ul>";
        foreach ($_SESSION['cart'] as $productId => $item) {
            echo "<li>Product ID: $productId, Quantity: {$item['quantity']}</li>";
        }
        echo "</ul>";
    }
    
    echo "<h3>Test Checkout Process:</h3>";
    if (!$isLoggedIn) {
        echo "<p>❌ Cannot test checkout - user not logged in</p>";
        echo "<p><a href='/login'>Login first</a></p>";
    } elseif (!$hasCartItems) {
        echo "<p>❌ Cannot test checkout - cart is empty</p>";
        echo "<p><a href='/products'>Add products to cart first</a></p>";
    } else {
        echo "<p>✅ Ready to test checkout</p>";
        echo "<p><a href='/checkout' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Checkout</a></p>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
table { margin: 20px 0; }
th, td { padding: 8px; text-align: left; }
th { background: #f0f0f0; }
a { margin-right: 10px; }
</style>

<div style="margin-top: 30px;">
    <h3>Navigation Links:</h3>
    <a href="/">Home</a>
    <a href="/products">Products</a>
    <a href="/cart">Cart</a>
    <a href="/checkout">Checkout</a>
    <a href="/login">Login</a>
    <a href="/register">Register</a>
</div>
