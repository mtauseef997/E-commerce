<?php
require_once 'config/app.php';

echo "<h2>Autoloader Testing & Diagnostics</h2>";

// Get the autoloader instance (assuming it's available globally)
// Since we can't access the autoloader directly, we'll test class loading

echo "<h3>Testing Class Loading</h3>";

$testClasses = [
    'App\\Controllers\\HomeController',
    'App\\Controllers\\ProductController',
    'App\\Controllers\\CartController',
    'App\\Controllers\\UserController',
    'App\\Controllers\\AdminController',
    'App\\Controllers\\WishlistController',
    'App\\Controllers\\CheckoutController',
    'App\\Models\\Product',
    'App\\Models\\User',
    'App\\Models\\Category',
    'App\\Models\\Order',
    'App\\Models\\Wishlist',
    'App\\Core\\Controller',
    'App\\Core\\Model',
    'App\\Core\\Router',
    'App\\Core\\Request',
    'App\\Core\\View',
    'App\\Core\\Database'
];

echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr style='background: #f0f0f0;'>";
echo "<th style='padding: 10px; text-align: left;'>Class</th>";
echo "<th style='padding: 10px; text-align: left;'>Status</th>";
echo "<th style='padding: 10px; text-align: left;'>File Path</th>";
echo "</tr>";

foreach ($testClasses as $className) {
    $status = "❌ Not Found";
    $filePath = "N/A";
    $statusColor = "#ffebee";
    
    try {
        // Convert class name to file path
        $relativePath = str_replace('App\\', '', $className);
        $filePath = ROOT_PATH . '/app/' . str_replace('\\', '/', $relativePath) . '.php';
        
        if (file_exists($filePath)) {
            if (class_exists($className)) {
                $status = "✅ Loaded";
                $statusColor = "#e8f5e8";
            } else {
                $status = "⚠️ File exists but class not loaded";
                $statusColor = "#fff3e0";
            }
        } else {
            $status = "❌ File not found";
            $statusColor = "#ffebee";
        }
    } catch (Exception $e) {
        $status = "❌ Error: " . $e->getMessage();
        $statusColor = "#ffebee";
    }
    
    echo "<tr style='background: $statusColor;'>";
    echo "<td style='padding: 8px; font-family: monospace;'>$className</td>";
    echo "<td style='padding: 8px; font-weight: bold;'>$status</td>";
    echo "<td style='padding: 8px; font-family: monospace; font-size: 0.9em;'>" . str_replace(ROOT_PATH, '', $filePath) . "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h3>Autoloader Configuration Test</h3>";

// Test if we can create instances of key classes
$instanceTests = [
    'App\\Core\\Request' => 'Request',
    'App\\Models\\Product' => 'Product Model',
    'App\\Models\\User' => 'User Model'
];

echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-top: 20px;'>";
echo "<tr style='background: #f0f0f0;'>";
echo "<th style='padding: 10px; text-align: left;'>Class</th>";
echo "<th style='padding: 10px; text-align: left;'>Instance Creation</th>";
echo "<th style='padding: 10px; text-align: left;'>Details</th>";
echo "</tr>";

foreach ($instanceTests as $className => $displayName) {
    $status = "❌ Failed";
    $details = "";
    $statusColor = "#ffebee";
    
    try {
        if (class_exists($className)) {
            // Try to create an instance
            $reflection = new ReflectionClass($className);
            
            if ($reflection->isInstantiable()) {
                $instance = new $className();
                $status = "✅ Success";
                $details = "Instance created successfully";
                $statusColor = "#e8f5e8";
            } else {
                $status = "⚠️ Not instantiable";
                $details = "Class exists but cannot be instantiated";
                $statusColor = "#fff3e0";
            }
        } else {
            $status = "❌ Class not found";
            $details = "Class does not exist or failed to load";
            $statusColor = "#ffebee";
        }
    } catch (Exception $e) {
        $status = "❌ Error";
        $details = $e->getMessage();
        $statusColor = "#ffebee";
    }
    
    echo "<tr style='background: $statusColor;'>";
    echo "<td style='padding: 8px; font-family: monospace;'>$displayName</td>";
    echo "<td style='padding: 8px; font-weight: bold;'>$status</td>";
    echo "<td style='padding: 8px;'>$details</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h3>File System Check</h3>";

$directories = [
    '/app/Controllers',
    '/app/Models', 
    '/app/Core',
    '/app/Views'
];

echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-top: 20px;'>";
echo "<tr style='background: #f0f0f0;'>";
echo "<th style='padding: 10px; text-align: left;'>Directory</th>";
echo "<th style='padding: 10px; text-align: left;'>Status</th>";
echo "<th style='padding: 10px; text-align: left;'>File Count</th>";
echo "</tr>";

foreach ($directories as $dir) {
    $fullPath = ROOT_PATH . $dir;
    $status = "❌ Not Found";
    $fileCount = 0;
    $statusColor = "#ffebee";
    
    if (is_dir($fullPath)) {
        $files = glob($fullPath . '/*.php');
        $fileCount = count($files);
        $status = "✅ Exists";
        $statusColor = "#e8f5e8";
    }
    
    echo "<tr style='background: $statusColor;'>";
    echo "<td style='padding: 8px; font-family: monospace;'>$dir</td>";
    echo "<td style='padding: 8px; font-weight: bold;'>$status</td>";
    echo "<td style='padding: 8px;'>$fileCount PHP files</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h3>Autoloader Performance Test</h3>";

$startTime = microtime(true);
$testIterations = 100;

for ($i = 0; $i < $testIterations; $i++) {
    class_exists('App\\Controllers\\HomeController');
    class_exists('App\\Models\\Product');
    class_exists('App\\Core\\Controller');
}

$endTime = microtime(true);
$totalTime = ($endTime - $startTime) * 1000; // Convert to milliseconds
$avgTime = $totalTime / $testIterations;

echo "<div style='background: #f0f0f0; padding: 15px; border-radius: 5px; margin-top: 20px;'>";
echo "<p><strong>Performance Results:</strong></p>";
echo "<ul>";
echo "<li>Total time for $testIterations iterations: " . number_format($totalTime, 2) . " ms</li>";
echo "<li>Average time per iteration: " . number_format($avgTime, 4) . " ms</li>";
echo "<li>Classes per second: " . number_format(($testIterations * 3) / ($totalTime / 1000), 0) . "</li>";
echo "</ul>";
echo "</div>";

echo "<h3>System Information</h3>";

echo "<div style='background: #f0f0f0; padding: 15px; border-radius: 5px; margin-top: 20px;'>";
echo "<ul>";
echo "<li><strong>PHP Version:</strong> " . PHP_VERSION . "</li>";
echo "<li><strong>Root Path:</strong> " . ROOT_PATH . "</li>";
echo "<li><strong>Include Path:</strong> " . get_include_path() . "</li>";
echo "<li><strong>Loaded Extensions:</strong> " . implode(', ', array_slice(get_loaded_extensions(), 0, 10)) . "...</li>";
echo "<li><strong>Memory Usage:</strong> " . number_format(memory_get_usage() / 1024 / 1024, 2) . " MB</li>";
echo "<li><strong>Peak Memory:</strong> " . number_format(memory_get_peak_usage() / 1024 / 1024, 2) . " MB</li>";
echo "</ul>";
echo "</div>";

?>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background: #fafafa;
}

h2, h3 {
    color: #333;
    border-bottom: 2px solid #007cba;
    padding-bottom: 5px;
}

table {
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 5px;
    overflow: hidden;
}

th {
    background: #007cba !important;
    color: white !important;
}

tr:nth-child(even) {
    background: #f9f9f9;
}

.success { background: #e8f5e8 !important; }
.warning { background: #fff3e0 !important; }
.error { background: #ffebee !important; }
</style>

<div style="margin-top: 30px; text-align: center;">
    <a href="/" style="background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Back to Home</a>
    <a href="/admin" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px;">Admin Panel</a>
</div>
