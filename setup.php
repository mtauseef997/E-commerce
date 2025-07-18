<?php
/**
 * Database Setup Script
 * This script creates the database and tables for the e-commerce application
 */

// Start session and include configuration
session_start();
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/config/config.php';

// HTML header
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup - <?= APP_NAME ?></title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { color: #28a745; background: #d4edda; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: #0c5460; background: #d1ecf1; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .btn { background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 5px 10px 0; }
        .btn:hover { background: #0056b3; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🚀 <?= APP_NAME ?> Setup</h1>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['setup'])) {
        echo "<h2>Setting up database...</h2>";
        
        try {
            // Connect to MySQL server (without database)
            $pdo = new PDO("mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo "<div class='success'>✓ Connected to MySQL server</div>";
            
            // Create database if it doesn't exist
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "<div class='success'>✓ Database '" . DB_NAME . "' created/verified</div>";
            
            // Use the database
            $pdo->exec("USE `" . DB_NAME . "`");
            
            // Read and execute schema
            $schemaFile = ROOT_PATH . '/database/schema.sql';
            if (file_exists($schemaFile)) {
                $schema = file_get_contents($schemaFile);
                
                // Split the schema into individual statements
                $statements = array_filter(array_map('trim', explode(';', $schema)));
                
                foreach ($statements as $statement) {
                    if (!empty($statement) && !preg_match('/^(CREATE DATABASE|USE)/i', $statement)) {
                        $pdo->exec($statement);
                    }
                }
                
                echo "<div class='success'>✓ Database schema created successfully</div>";
            } else {
                echo "<div class='error'>✗ Schema file not found: {$schemaFile}</div>";
            }
            
            // Check if tables were created
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo "<div class='info'>📊 Created tables: " . implode(', ', $tables) . "</div>";
            
            // Check sample data
            if (in_array('products', $tables)) {
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM products");
                $productCount = $stmt->fetch()['count'];
                echo "<div class='info'>📦 Sample products: {$productCount}</div>";
            }
            
            if (in_array('users', $tables)) {
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
                $userCount = $stmt->fetch()['count'];
                echo "<div class='info'>👥 Sample users: {$userCount}</div>";
            }
            
            echo "<div class='success'><strong>🎉 Setup completed successfully!</strong></div>";
            echo "<div class='info'>";
            echo "<h3>Next Steps:</h3>";
            echo "<ul>";
            echo "<li><a href='generate_placeholders.php' class='btn'>Generate Product Images</a></li>";
            echo "<li><a href='test' class='btn'>Test Application</a></li>";
            echo "<li><a href='/' class='btn'>Visit Homepage</a></li>";
            echo "</ul>";
            echo "</div>";
            
            echo "<div class='info'>";
            echo "<h3>Default Login Credentials:</h3>";
            echo "<p><strong>Admin:</strong> admin@modernshop.com / password</p>";
            echo "<p><strong>User:</strong> john@example.com / password</p>";
            echo "</div>";
            
        } catch (PDOException $e) {
            echo "<div class='error'>✗ Database error: " . htmlspecialchars($e->getMessage()) . "</div>";
            echo "<div class='info'>";
            echo "<h3>Troubleshooting:</h3>";
            echo "<ul>";
            echo "<li>Make sure MySQL is running</li>";
            echo "<li>Check database credentials in config/config.php</li>";
            echo "<li>Ensure the database user has CREATE privileges</li>";
            echo "</ul>";
            echo "</div>";
        } catch (Exception $e) {
            echo "<div class='error'>✗ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    } else {
        // Show setup form
        ?>
        <div class="info">
            <h2>Database Configuration</h2>
            <p><strong>Host:</strong> <?= DB_HOST ?></p>
            <p><strong>Database:</strong> <?= DB_NAME ?></p>
            <p><strong>User:</strong> <?= DB_USER ?></p>
            <p><strong>Charset:</strong> <?= DB_CHARSET ?></p>
        </div>
        
        <div class="info">
            <h3>This setup will:</h3>
            <ul>
                <li>Create the database if it doesn't exist</li>
                <li>Create all required tables</li>
                <li>Insert sample data (products, categories, users)</li>
                <li>Set up test accounts</li>
            </ul>
        </div>
        
        <form method="POST">
            <button type="submit" name="setup" class="btn" style="font-size: 16px; padding: 15px 30px;">
                🚀 Start Setup
            </button>
        </form>
        
        <div class="info">
            <h3>Manual Setup (Alternative)</h3>
            <p>If you prefer to set up manually:</p>
            <ol>
                <li>Create database: <code>CREATE DATABASE <?= DB_NAME ?>;</code></li>
                <li>Import schema: <code>mysql -u <?= DB_USER ?> -p <?= DB_NAME ?> < database/schema.sql</code></li>
            </ol>
        </div>
        <?php
    }
    ?>
    
    <hr>
    <p><small>ModernShop E-Commerce Setup • <a href="/">Back to Application</a></small></p>
</body>
</html>
