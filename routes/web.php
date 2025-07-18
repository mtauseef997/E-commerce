<?php
$router->get('/test', function () {
    echo '<!DOCTYPE html><html><head>';
    echo '<title>ModernShop Test</title>';
    echo '<link rel="stylesheet" href="css/main.css">';
    echo '<link rel="stylesheet" href="css/components.css">';
    echo '<style>body{font-family:Arial,sans-serif;padding:20px;} .test-box{background:#6366f1;color:white;padding:20px;margin:10px 0;border-radius:8px;}</style>';
    echo '</head><body>';
    echo '<h1>ModernShop Debug Test</h1>';
    echo '<p><strong>APP_URL:</strong> ' . APP_URL . '</p>';
    echo '<p><strong>Current URL:</strong> ' . $_SERVER['REQUEST_URI'] . '</p>';
    echo '<h2>CSS URL Tests:</h2>';
    echo '<p>Direct CSS: <a href="css/main.css" target="_blank">css/main.css</a></p>';
    echo '<p>APP_URL CSS: <a href="' . APP_URL . '/css/main.css" target="_blank">' . APP_URL . '/css/main.css</a></p>';
    echo '<h2>Database Test:</h2>';
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASS);
        echo '<p style="color: green;">✓ Database connection successful</p>';
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo '<p><strong>Tables found (' . count($tables) . '):</strong> ' . implode(', ', $tables) . '</p>';
        if (in_array('products', $tables)) {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM products");
            $count = $stmt->fetch()['count'];
            echo '<p><strong>Products in database:</strong> ' . $count . '</p>';
        }
    } catch (PDOException $e) {
        echo '<p style="color: red;">✗ Database connection failed: ' . $e->getMessage() . '</p>';
        echo '<p><strong>Suggestion:</strong> Run <a href="setup.php">setup.php</a> to create database and tables.</p>';
    }
    echo '<div class="test-box">This box should be blue if CSS is working</div>';
    echo '<div class="btn btn-primary">Test Button (should be styled if CSS loads)</div>';
    echo '<h2>Quick Actions:</h2>';
    echo '<p><a href="/">Go to Homepage</a> | <a href="setup.php">Run Setup</a> | <a href="generate_placeholders.php">Generate Images</a></p>';
    echo '</body></html>';
});
$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');
$router->get('/products', 'ProductController@index');
$router->get('/product/{id}', 'ProductController@show');
$router->get('/category/{id}', 'ProductController@category');
$router->get('/search', 'ProductController@search');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');
$router->get('/profile', 'UserController@profile');
$router->post('/profile', 'UserController@updateProfile');
$router->get('/orders', 'UserController@orders');
// Pages routes
$router->get('/about', 'PagesController@about');
$router->get('/contact', 'PagesController@contact');
$router->post('/contact', 'PagesController@contact');
$router->get('/privacy', 'PagesController@privacy');
$router->get('/terms', 'PagesController@terms');
$router->get('/faq', 'PagesController@faq');
$router->get('/order/{id}', 'UserController@orderDetails');
$router->get('/cart', 'CartController@index');
$router->post('/cart/add', 'CartController@add');
$router->post('/cart/update', 'CartController@update');
$router->post('/cart/remove', 'CartController@remove');
$router->get('/cart/clear', 'CartController@clear');
$router->get('/checkout', 'CheckoutController@index');
$router->post('/checkout', 'CheckoutController@process');
$router->post('/checkout/process', 'CheckoutController@process');
$router->get('/checkout/success', 'CheckoutController@success');
// Wishlist routes
$router->get('/wishlist', 'WishlistController@index');
$router->post('/wishlist/add', 'WishlistController@add');
$router->post('/wishlist/remove', 'WishlistController@remove');
$router->post('/wishlist/toggle', 'WishlistController@toggle');
$router->post('/wishlist/clear', 'WishlistController@clear');
$router->get('/admin', 'AdminController@dashboard');
$router->get('/admin/products', 'AdminController@products');
$router->get('/admin/product/create', 'AdminController@createProduct');
$router->post('/admin/product/create', 'AdminController@storeProduct');
$router->get('/admin/product/{id}/edit', 'AdminController@editProduct');
$router->post('/admin/product/{id}/edit', 'AdminController@updateProduct');
$router->post('/admin/product/{id}/delete', 'AdminController@deleteProduct');
$router->get('/admin/categories', 'AdminController@categories');
$router->get('/admin/orders', 'AdminController@orders');
$router->get('/admin/users', 'AdminController@users');
$router->post('/api/cart/count', 'ApiController@cartCount');
$router->post('/api/wishlist/toggle', 'ApiController@toggleWishlist');
