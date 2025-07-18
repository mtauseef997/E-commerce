<?php
require_once 'config/database.php';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Testing Cart Functionality</h2>";
    
    // Check if products exist
    $stmt = $db->query("SELECT COUNT(*) as count FROM products WHERE status = 'active'");
    $productCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p>Active products in database: $productCount</p>";
    
    if ($productCount == 0) {
        echo "<h3>Adding test products...</h3>";
        
        // Add a test category first
        $stmt = $db->prepare("INSERT IGNORE INTO categories (name, slug, description, status) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Electronics', 'electronics', 'Electronic products', 'active']);
        $categoryId = $db->lastInsertId() ?: 1;
        
        // Add test products
        $products = [
            [
                'name' => 'Test Laptop',
                'slug' => 'test-laptop',
                'description' => 'A test laptop for cart functionality',
                'price' => 999.99,
                'category_id' => $categoryId,
                'stock_quantity' => 10,
                'stock_status' => 'in_stock',
                'manage_stock' => 1,
                'status' => 'active'
            ],
            [
                'name' => 'Test Phone',
                'slug' => 'test-phone',
                'description' => 'A test phone for cart functionality',
                'price' => 599.99,
                'category_id' => $categoryId,
                'stock_quantity' => 5,
                'stock_status' => 'in_stock',
                'manage_stock' => 1,
                'status' => 'active'
            ]
        ];
        
        $stmt = $db->prepare("
            INSERT INTO products (name, slug, description, price, category_id, stock_quantity, stock_status, manage_stock, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        
        foreach ($products as $product) {
            $stmt->execute([
                $product['name'],
                $product['slug'],
                $product['description'],
                $product['price'],
                $product['category_id'],
                $product['stock_quantity'],
                $product['stock_status'],
                $product['manage_stock'],
                $product['status']
            ]);
            echo "<p>Added product: {$product['name']}</p>";
        }
    }
    
    // Show current products
    echo "<h3>Current Products:</h3>";
    $stmt = $db->query("
        SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.status = 'active' 
        ORDER BY p.id DESC 
        LIMIT 5
    ");
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Status</th><th>Category</th><th>Test Cart</th></tr>";
    
    while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$product['id']}</td>";
        echo "<td>{$product['name']}</td>";
        echo "<td>\${$product['price']}</td>";
        echo "<td>{$product['stock_quantity']}</td>";
        echo "<td>{$product['stock_status']}</td>";
        echo "<td>{$product['category_name']}</td>";
        echo "<td><button onclick='testAddToCart({$product['id']})'>Add to Cart</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h3>Cart Test Results:</h3>";
    echo "<div id='cart-results'></div>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<script>
async function testAddToCart(productId) {
    console.log('Testing add to cart for product:', productId);
    
    try {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', 1);
        
        const response = await fetch('/cart/add', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        console.log('Response status:', response.status);
        console.log('Response headers:', [...response.headers.entries()]);
        
        const text = await response.text();
        console.log('Response text:', text);
        
        document.getElementById('cart-results').innerHTML += 
            `<p><strong>Product ${productId}:</strong> Status ${response.status} - ${text}</p>`;
            
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('cart-results').innerHTML += 
            `<p><strong>Product ${productId}:</strong> Error - ${error.message}</p>`;
    }
}
</script>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
table { margin: 20px 0; }
th, td { padding: 8px; text-align: left; }
button { padding: 5px 10px; background: #007cba; color: white; border: none; cursor: pointer; }
button:hover { background: #005a87; }
#cart-results { background: #f0f0f0; padding: 10px; margin: 20px 0; min-height: 50px; }
</style>

<div style="margin-top: 30px;">
    <h3>Navigation Links:</h3>
    <a href="/" style="margin-right: 10px;">Home</a>
    <a href="/products" style="margin-right: 10px;">Products</a>
    <a href="/cart" style="margin-right: 10px;">Cart</a>
    <a href="/admin/products" style="margin-right: 10px;">Admin Products</a>
</div>
