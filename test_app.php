<?php
/**
 * Simple test script to check application functionality
 */

// Set up basic environment
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('CONFIG_PATH', ROOT_PATH . '/config');

echo "<h1>ModernShop Application Test</h1>\n";

// Test 1: Check if config file exists and is readable
echo "<h2>1. Configuration Test</h2>\n";
if (file_exists(CONFIG_PATH . '/config.php')) {
    echo "✓ Config file exists<br>\n";
    require_once CONFIG_PATH . '/config.php';
    echo "✓ Config file loaded successfully<br>\n";
    echo "APP_NAME: " . (defined('APP_NAME') ? APP_NAME : 'NOT DEFINED') . "<br>\n";
    echo "APP_URL: " . (defined('APP_URL') ? APP_URL : 'NOT DEFINED') . "<br>\n";
    echo "DB_HOST: " . (defined('DB_HOST') ? DB_HOST : 'NOT DEFINED') . "<br>\n";
} else {
    echo "✗ Config file not found<br>\n";
}

// Test 2: Check autoloader
echo "<h2>2. Autoloader Test</h2>\n";
if (file_exists(ROOT_PATH . '/app/Core/Autoloader.php')) {
    echo "✓ Autoloader file exists<br>\n";
    require_once ROOT_PATH . '/app/Core/Autoloader.php';
    $autoloader = new App\Core\Autoloader();
    $autoloader->register();
    echo "✓ Autoloader registered successfully<br>\n";
} else {
    echo "✗ Autoloader file not found<br>\n";
}

// Test 3: Check database connection
echo "<h2>3. Database Connection Test</h2>\n";
try {
    if (defined('DB_HOST') && defined('DB_NAME') && defined('DB_USER')) {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "✓ Database connection successful<br>\n";
        
        // Check if tables exist
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "✓ Found " . count($tables) . " tables: " . implode(', ', $tables) . "<br>\n";
        
        if (in_array('products', $tables)) {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM products");
            $count = $stmt->fetch()['count'];
            echo "✓ Products table has " . $count . " records<br>\n";
        }
    } else {
        echo "✗ Database configuration not complete<br>\n";
    }
} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "<br>\n";
    echo "Suggestion: Run install.php to set up the database<br>\n";
}

// Test 4: Check core classes
echo "<h2>4. Core Classes Test</h2>\n";
$coreClasses = ['Database', 'Router', 'Controller', 'Model', 'View', 'Request'];
foreach ($coreClasses as $class) {
    $className = "App\\Core\\$class";
    if (class_exists($className)) {
        echo "✓ $class class loaded<br>\n";
    } else {
        echo "✗ $class class not found<br>\n";
    }
}

// Test 5: Check models
echo "<h2>5. Models Test</h2>\n";
$models = ['User', 'Product', 'Category', 'Order'];
foreach ($models as $model) {
    $modelName = "App\\Models\\$model";
    if (class_exists($modelName)) {
        echo "✓ $model model loaded<br>\n";
    } else {
        echo "✗ $model model not found<br>\n";
    }
}

// Test 6: Check controllers
echo "<h2>6. Controllers Test</h2>\n";
$controllers = ['HomeController', 'ProductController', 'AuthController', 'CartController'];
foreach ($controllers as $controller) {
    $controllerName = "App\\Controllers\\$controller";
    if (class_exists($controllerName)) {
        echo "✓ $controller loaded<br>\n";
    } else {
        echo "✗ $controller not found<br>\n";
    }
}

// Test 7: Check views
echo "<h2>7. Views Test</h2>\n";
$viewPaths = [
    'layouts/main.php',
    'home/index.php',
    'products/index.php',
    'auth/login.php',
    'errors/404.php'
];
foreach ($viewPaths as $viewPath) {
    $fullPath = ROOT_PATH . '/app/Views/' . $viewPath;
    if (file_exists($fullPath)) {
        echo "✓ View $viewPath exists<br>\n";
    } else {
        echo "✗ View $viewPath not found<br>\n";
    }
}

// Test 8: Check CSS files
echo "<h2>8. CSS Files Test</h2>\n";
$cssFiles = ['main.css', 'components.css', 'animations.css'];
foreach ($cssFiles as $cssFile) {
    $fullPath = ROOT_PATH . '/public/css/' . $cssFile;
    if (file_exists($fullPath)) {
        echo "✓ CSS file $cssFile exists<br>\n";
    } else {
        echo "✗ CSS file $cssFile not found<br>\n";
    }
}

echo "<h2>Test Complete</h2>\n";
echo "<p><a href='/'>Go to Homepage</a> | <a href='/install.php'>Run Installation</a></p>\n";
?>
