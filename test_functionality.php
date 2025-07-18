<?php
/**
 * Test Script to Verify E-Commerce Application Functionality
 */

session_start();
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('CONFIG_PATH', ROOT_PATH . '/config');

require_once ROOT_PATH . '/app/Core/Autoloader.php';
$autoloader = new App\Core\Autoloader();
$autoloader->register();

require_once CONFIG_PATH . '/config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Functionality Test - <?= APP_NAME ?></title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 20px auto; padding: 20px; }
        .test-section { margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .info { color: #17a2b8; }
        .warning { color: #ffc107; }
        .btn { background: #007bff; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; margin: 5px; display: inline-block; }
        .btn:hover { background: #0056b3; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 4px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f8f9fa; }
    </style>
</head>
<body>
    <h1>🧪 <?= APP_NAME ?> Functionality Test</h1>
    
    <div class="test-section">
        <h2>1. Core Components Test</h2>
        <?php
        echo "<h3>Autoloader</h3>";
        try {
            $router = new App\Core\Router();
            echo "<p class='success'>✓ Router class loaded successfully</p>";
            
            $database = App\Core\Database::getInstance();
            echo "<p class='success'>✓ Database singleton created</p>";
            
            $view = new App\Core\View();
            echo "<p class='success'>✓ View class loaded successfully</p>";
            
        } catch (Exception $e) {
            echo "<p class='error'>✗ Core component error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

    <div class="test-section">
        <h2>2. Database Connection Test</h2>
        <?php
        try {
            $db = App\Core\Database::getInstance()->getConnection();
            echo "<p class='success'>✓ Database connection successful</p>";
            
            // Test tables
            $stmt = $db->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            if (empty($tables)) {
                echo "<p class='warning'>⚠ No tables found. <a href='setup.php' class='btn'>Run Setup</a></p>";
            } else {
                echo "<p class='success'>✓ Found " . count($tables) . " tables</p>";
                echo "<p><strong>Tables:</strong> " . implode(', ', $tables) . "</p>";
                
                // Test sample data
                if (in_array('products', $tables)) {
                    $stmt = $db->query("SELECT COUNT(*) as count FROM products");
                    $productCount = $stmt->fetch()['count'];
                    echo "<p class='info'>📦 Products: {$productCount}</p>";
                }
                
                if (in_array('categories', $tables)) {
                    $stmt = $db->query("SELECT COUNT(*) as count FROM categories");
                    $categoryCount = $stmt->fetch()['count'];
                    echo "<p class='info'>📂 Categories: {$categoryCount}</p>";
                }
                
                if (in_array('users', $tables)) {
                    $stmt = $db->query("SELECT COUNT(*) as count FROM users");
                    $userCount = $stmt->fetch()['count'];
                    echo "<p class='info'>👥 Users: {$userCount}</p>";
                }
            }
            
        } catch (Exception $e) {
            echo "<p class='error'>✗ Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><a href='setup.php' class='btn'>Setup Database</a></p>";
        }
        ?>
    </div>

    <div class="test-section">
        <h2>3. Model Tests</h2>
        <?php
        try {
            $productModel = new App\Models\Product();
            echo "<p class='success'>✓ Product model loaded</p>";
            
            $categoryModel = new App\Models\Category();
            echo "<p class='success'>✓ Category model loaded</p>";
            
            $userModel = new App\Models\User();
            echo "<p class='success'>✓ User model loaded</p>";
            
            // Test model methods
            if (!empty($tables) && in_array('products', $tables)) {
                $featuredProducts = $productModel->getFeatured(3);
                echo "<p class='info'>📦 Featured products: " . count($featuredProducts) . "</p>";
                
                $categories = $categoryModel->getWithProductCount();
                echo "<p class='info'>📂 Categories with product count: " . count($categories) . "</p>";
            }
            
        } catch (Exception $e) {
            echo "<p class='error'>✗ Model error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

    <div class="test-section">
        <h2>4. Controller Tests</h2>
        <?php
        try {
            $homeController = new App\Controllers\HomeController();
            echo "<p class='success'>✓ HomeController loaded</p>";
            
            $productController = new App\Controllers\ProductController();
            echo "<p class='success'>✓ ProductController loaded</p>";
            
            $authController = new App\Controllers\AuthController();
            echo "<p class='success'>✓ AuthController loaded</p>";
            
            $cartController = new App\Controllers\CartController();
            echo "<p class='success'>✓ CartController loaded</p>";
            
        } catch (Exception $e) {
            echo "<p class='error'>✗ Controller error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

    <div class="test-section">
        <h2>5. View Tests</h2>
        <?php
        $viewFiles = [
            'layouts/main.php',
            'home/index.php',
            'home/setup_required.php',
            'products/index.php',
            'auth/login.php',
            'cart/index.php',
            'errors/404.php'
        ];
        
        foreach ($viewFiles as $viewFile) {
            $fullPath = ROOT_PATH . '/app/Views/' . $viewFile;
            if (file_exists($fullPath)) {
                echo "<p class='success'>✓ {$viewFile}</p>";
            } else {
                echo "<p class='error'>✗ {$viewFile} missing</p>";
            }
        }
        ?>
    </div>

    <div class="test-section">
        <h2>6. Static Assets Test</h2>
        <?php
        $assetFiles = [
            'public/css/main.css',
            'public/css/components.css',
            'public/css/animations.css',
            'public/js/main.js'
        ];
        
        foreach ($assetFiles as $assetFile) {
            $fullPath = ROOT_PATH . '/' . $assetFile;
            if (file_exists($fullPath)) {
                echo "<p class='success'>✓ {$assetFile}</p>";
            } else {
                echo "<p class='error'>✗ {$assetFile} missing</p>";
            }
        }
        ?>
    </div>

    <div class="test-section">
        <h2>7. Configuration Test</h2>
        <table>
            <tr><th>Setting</th><th>Value</th></tr>
            <tr><td>APP_NAME</td><td><?= APP_NAME ?></td></tr>
            <tr><td>APP_URL</td><td><?= APP_URL ?></td></tr>
            <tr><td>APP_ENV</td><td><?= APP_ENV ?></td></tr>
            <tr><td>DB_HOST</td><td><?= DB_HOST ?></td></tr>
            <tr><td>DB_NAME</td><td><?= DB_NAME ?></td></tr>
            <tr><td>DB_USER</td><td><?= DB_USER ?></td></tr>
        </table>
    </div>

    <div class="test-section">
        <h2>8. Quick Actions</h2>
        <a href="/" class="btn">🏠 Homepage</a>
        <a href="/products" class="btn">🛍️ Products</a>
        <a href="/login" class="btn">🔐 Login</a>
        <a href="/cart" class="btn">🛒 Cart</a>
        <a href="/admin" class="btn">⚙️ Admin</a>
        <a href="setup.php" class="btn">🚀 Setup</a>
        <a href="generate_placeholders.php" class="btn">🖼️ Generate Images</a>
    </div>

    <div class="test-section">
        <h2>9. System Information</h2>
        <table>
            <tr><th>Item</th><th>Value</th></tr>
            <tr><td>PHP Version</td><td><?= PHP_VERSION ?></td></tr>
            <tr><td>Server Software</td><td><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></td></tr>
            <tr><td>Document Root</td><td><?= $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' ?></td></tr>
            <tr><td>Current Time</td><td><?= date('Y-m-d H:i:s') ?></td></tr>
            <tr><td>Memory Limit</td><td><?= ini_get('memory_limit') ?></td></tr>
            <tr><td>Max Execution Time</td><td><?= ini_get('max_execution_time') ?> seconds</td></tr>
        </table>
    </div>

    <hr>
    <p><small>ModernShop E-Commerce Functionality Test • Generated at <?= date('Y-m-d H:i:s') ?></small></p>
</body>
</html>
